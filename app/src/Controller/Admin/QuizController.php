<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Form\Admin\QuizType;
use App\Repository\QuizRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/quiz', name: 'app_admin_quiz_')]
final class QuizController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(QuizRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['createdAt' => 'DESC']), 'title' => 'Quiz', 'description' => 'Administrer les parcours Quiz, leurs questions et leurs réponses.', 'userStory' => 'US51 — Gérer le quiz', 'newRoute' => 'app_admin_quiz_new', 'newLabel' => 'Ajouter un Quiz', 'editRoute' => 'app_admin_quiz_edit', 'deleteRoute' => 'app_admin_quiz_delete', 'deleteTokenPrefix' => 'delete-quiz-', 'displayProperty' => 'title', 'subtitleProperty' => 'description', 'countProperty' => 'questions', 'secondaryActions' => [['route' => 'app_admin_quiz_question_index', 'label' => 'Gérer les Questions'], ['route' => 'app_admin_quiz_reponse_index', 'label' => 'Gérer les Réponses']]]); }

    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { $quiz = (new Quiz())->setCreatedAt(new \DateTimeImmutable()); return $this->save($quiz, $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Quiz $quiz, Request $request, EntityManagerInterface $em): Response { return $this->save($quiz, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Quiz $quiz, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-quiz-'.$quiz->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } elseif (!$quiz->getQuestions()->isEmpty() || !$quiz->getQuizResults()->isEmpty()) { $this->addFlash('error', 'Ce Quiz possède encore des questions ou des résultats.'); } else { try { $em->remove($quiz); $em->flush(); $this->addFlash('success', 'Le Quiz a été supprimé.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Ce Quiz est encore utilisé.'); } } return $this->redirectToRoute('app_admin_quiz_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Quiz $quiz, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(QuizType::class, $quiz)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($quiz); $em->flush(); $this->addFlash('success', 'Le Quiz a été enregistré.'); return $this->redirectToRoute('app_admin_quiz_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouveau Quiz', 'editTitle' => 'Modifier le Quiz', 'userStory' => 'US51 — Gérer le quiz', 'indexRoute' => 'app_admin_quiz_index']); }
}
