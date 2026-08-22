<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\User;
use App\Enum\FavoriteEntityType;
use App\Repository\DieuRepository;
use App\Repository\FavoriteRepository;
use App\Service\QuizV1Engine;
use App\Service\QuizV1Presentation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/quiz', name: 'app_quiz_')]
#[IsGranted('ROLE_USER')]
final class QuizController extends AbstractController
{
    private const SESSION_KEY = 'quiz_v1_attempt';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('quiz/index.html.twig', [
            'hasAttempt' => $request->getSession()->has(self::SESSION_KEY),
        ]);
    }

    #[Route('/commencer', name: 'start', methods: ['POST'])]
    public function start(Request $request, QuizV1Engine $engine): RedirectResponse
    {
        if (!$this->isCsrfTokenValid('quiz-start', (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $attempt = $engine->newAttempt();
        $attempt['nonce'] = bin2hex(random_bytes(16));
        $request->getSession()->set(self::SESSION_KEY, $attempt);

        return $this->redirectToRoute('app_quiz_question', ['position' => 1]);
    }

    #[Route('/question/{position}', name: 'question', requirements: ['position' => '\\d+'], methods: ['GET'])]
    public function question(Request $request, QuizV1Engine $engine, QuizV1Presentation $presentation, int $position): Response
    {
        $attempt = $this->attempt($request);
        if ($attempt === null) {
            return $this->redirectToRoute('app_quiz_index');
        }

        $index = $position - 1;
        $furthestReachable = min(count($attempt['answers']), QuizV1Engine::QUESTION_COUNT - 1);
        if ($index < 0 || $index > $furthestReachable) {
            return $this->redirectToRoute('app_quiz_question', ['position' => $furthestReachable + 1]);
        }

        $question = $engine->publicQuestion($attempt, $index);

        return $this->render('quiz/question.html.twig', [
            'question' => $question,
            'questionHint' => $presentation->questionHint($question['id']),
            'questionImage' => $presentation->questionImage($question['id']),
            'position' => $position,
            'total' => QuizV1Engine::QUESTION_COUNT,
            'selectedAnswer' => $attempt['answers'][$question['id']] ?? null,
            'attemptNonce' => $attempt['nonce'],
        ]);
    }

    #[Route('/repondre', name: 'answer', methods: ['POST'])]
    public function answer(Request $request, QuizV1Engine $engine): RedirectResponse
    {
        $attempt = $this->attempt($request);
        if ($attempt === null) {
            return $this->redirectToRoute('app_quiz_index');
        }

        if (!$this->isCsrfTokenValid('quiz-answer-'.$attempt['nonce'], (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $position = $request->request->getInt('position');
        $index = $position - 1;
        if ($index < 0 || $index >= QuizV1Engine::QUESTION_COUNT) {
            throw $this->createNotFoundException('Position de question invalide.');
        }

        $publicQuestion = $engine->publicQuestion($attempt, $index);
        $questionId = (string) $request->request->get('question');
        $answerId = (string) $request->request->get('answer');
        $allowedAnswerIds = array_column($publicQuestion['answers'], 'id');

        if ($questionId !== $publicQuestion['id'] || !in_array($answerId, $allowedAnswerIds, true)) {
            $this->addFlash('quiz_error', 'Choisis une réponse avant de continuer.');

            return $this->redirectToRoute('app_quiz_question', ['position' => $position]);
        }

        $attempt['answers'][$questionId] = $answerId;
        $request->getSession()->set(self::SESSION_KEY, $attempt);

        if (count($attempt['answers']) === QuizV1Engine::QUESTION_COUNT && $position === QuizV1Engine::QUESTION_COUNT) {
            return $this->redirectToRoute('app_quiz_result');
        }

        return $this->redirectToRoute('app_quiz_question', [
            'position' => min($position + 1, QuizV1Engine::QUESTION_COUNT),
        ]);
    }

    #[Route('/resultat', name: 'result', methods: ['GET'])]
    public function result(
        Request $request,
        QuizV1Engine $engine,
        QuizV1Presentation $presentation,
        DieuRepository $dieuRepository,
        FavoriteRepository $favoriteRepository,
    ): Response {
        $attempt = $this->attempt($request);
        if ($attempt === null || count($attempt['answers']) !== QuizV1Engine::QUESTION_COUNT) {
            return $this->redirectToRoute('app_quiz_index');
        }

        $winnerName = $engine->calculate($attempt['answers'])['winner'];
        $dieu = $dieuRepository->findOneBy(['name' => $winnerName]);
        if ($dieu === null) {
            throw new \LogicException(sprintf('La divinité du Quiz « %s » est absente de la base.', $winnerName));
        }
        if (!$dieu->isVisible() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('Cette divinité n’est pas publiée.');
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $isFavorite = $favoriteRepository->findOneBy([
            'user' => $user,
            'entityType' => FavoriteEntityType::DIEU,
            'entityId' => $dieu->getId(),
        ]) !== null;

        return $this->render('quiz/result.html.twig', [
            'dieu' => $dieu,
            'characteristics' => $presentation->deityTraits((string) $dieu->getName()),
            'isFavorite' => $isFavorite,
            'attemptNonce' => $attempt['nonce'],
        ]);
    }

    #[Route('/favori', name: 'favorite', methods: ['POST'])]
    public function favorite(
        Request $request,
        QuizV1Engine $engine,
        DieuRepository $dieuRepository,
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $entityManager,
    ): RedirectResponse {
        $attempt = $this->attempt($request);
        if ($attempt === null || count($attempt['answers']) !== QuizV1Engine::QUESTION_COUNT) {
            return $this->redirectToRoute('app_quiz_index');
        }

        if (!$this->isCsrfTokenValid('quiz-favorite-'.$attempt['nonce'], (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $winnerName = $engine->calculate($attempt['answers'])['winner'];
        $dieu = $dieuRepository->findOneBy(['name' => $winnerName]);
        $user = $this->getUser();
        if ($dieu === null || (!$dieu->isVisible() && !$this->isGranted('ROLE_ADMIN')) || !$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $existing = $favoriteRepository->findOneBy([
            'user' => $user,
            'entityType' => FavoriteEntityType::DIEU,
            'entityId' => $dieu->getId(),
        ]);

        if ($existing === null) {
            $favorite = (new Favorite())
                ->setUser($user)
                ->setEntityType(FavoriteEntityType::DIEU)
                ->setEntityId((int) $dieu->getId())
                ->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($favorite);
            $entityManager->flush();
            $this->addFlash('quiz_success', sprintf('%s a été ajouté à tes favoris.', $dieu->getName()));
        }

        return $this->redirectToRoute('app_quiz_result');
    }

    /**
     * @return array{questionOrder: list<string>, answerOrder: array<string, list<string>>, answers: array<string, string>, current: int, nonce: string}|null
     */
    private function attempt(Request $request): ?array
    {
        $attempt = $request->getSession()->get(self::SESSION_KEY);

        return is_array($attempt) ? $attempt : null;
    }
}
