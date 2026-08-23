<?php

namespace App\Controller\Admin;

use App\Entity\Reponse;
use App\Form\Admin\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/quiz/reponses', name: 'app_admin_quiz_reponse_')]
final class QuizReponseController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ReponseRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['id' => 'ASC']), 'title' => 'Réponses du Quiz', 'description' => 'Administrer les réponses, leurs points et leurs divinités.', 'userStory' => 'US51 — Gérer le quiz', 'newRoute' => 'app_admin_quiz_reponse_new', 'newLabel' => 'Ajouter une Réponse', 'editRoute' => 'app_admin_quiz_reponse_edit', 'deleteRoute' => 'app_admin_quiz_reponse_delete', 'deleteTokenPrefix' => 'delete-reponse-', 'displayProperty' => 'reponseText', 'subtitleProperty' => null, 'countProperty' => null, 'secondaryActions' => [['route' => 'app_admin_quiz_index', 'label' => 'Voir les Quiz'], ['route' => 'app_admin_quiz_question_index', 'label' => 'Voir les Questions']]]); }

    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { return $this->save(new Reponse(), $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Reponse $reponse, Request $request, EntityManagerInterface $em): Response { return $this->save($reponse, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Reponse $reponse, Request $request, EntityManagerInterface $em): Response { if ($this->isCsrfTokenValid('delete-reponse-'.$reponse->getId(), $request->getPayload()->getString('_token'))) { $em->remove($reponse); $em->flush(); $this->addFlash('success', 'La réponse a été supprimée.'); } else { $this->addFlash('error', 'Jeton de suppression invalide.'); } return $this->redirectToRoute('app_admin_quiz_reponse_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Reponse $reponse, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(ReponseType::class, $reponse)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($reponse); $em->flush(); $this->addFlash('success', 'La réponse a été enregistrée.'); return $this->redirectToRoute('app_admin_quiz_reponse_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouvelle Réponse', 'editTitle' => 'Modifier la Réponse', 'userStory' => 'US51 — Gérer le quiz', 'indexRoute' => 'app_admin_quiz_reponse_index']); }
}
