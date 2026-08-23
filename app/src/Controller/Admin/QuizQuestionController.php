<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\Admin\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/quiz/questions', name: 'app_admin_quiz_question_')]
final class QuizQuestionController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(QuestionRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['position' => 'ASC']), 'title' => 'Questions du Quiz', 'description' => 'Administrer les questions réellement rattachées aux Quiz Doctrine.', 'userStory' => 'US51 — Gérer le quiz', 'newRoute' => 'app_admin_quiz_question_new', 'newLabel' => 'Ajouter une Question', 'editRoute' => 'app_admin_quiz_question_edit', 'deleteRoute' => 'app_admin_quiz_question_delete', 'deleteTokenPrefix' => 'delete-question-', 'displayProperty' => 'question', 'subtitleProperty' => null, 'countProperty' => 'reponses', 'secondaryActions' => [['route' => 'app_admin_quiz_index', 'label' => 'Voir les Quiz'], ['route' => 'app_admin_quiz_reponse_index', 'label' => 'Voir les Réponses']]]); }

    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { return $this->save((new Question())->setPosition(1), $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Question $question, Request $request, EntityManagerInterface $em): Response { return $this->save($question, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Question $question, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-question-'.$question->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } elseif (!$question->getReponses()->isEmpty()) { $this->addFlash('error', 'Supprimez d’abord les réponses associées.'); } else { $em->remove($question); $em->flush(); $this->addFlash('success', 'La question a été supprimée.'); } return $this->redirectToRoute('app_admin_quiz_question_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Question $question, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(QuestionType::class, $question)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($question); $em->flush(); $this->addFlash('success', 'La question a été enregistrée.'); return $this->redirectToRoute('app_admin_quiz_question_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouvelle Question', 'editTitle' => 'Modifier la Question', 'userStory' => 'US51 — Gérer le quiz', 'indexRoute' => 'app_admin_quiz_question_index']); }
}
