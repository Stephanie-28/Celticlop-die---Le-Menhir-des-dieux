<?php

namespace App\Controller\Admin;

use App\Entity\Savoir;
use App\Form\Admin\SavoirType;
use App\Repository\SavoirRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/savoirs', name: 'app_admin_savoir_')]
final class SavoirController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SavoirRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['createdAt' => 'DESC']), 'title' => 'Savoirs préservés', 'description' => 'Administrer les savoirs conservés dans les archives.', 'userStory' => 'US49 — Gérer les savoirs préservés', 'newRoute' => 'app_admin_savoir_new', 'newLabel' => 'Ajouter un Savoir préservé', 'editRoute' => 'app_admin_savoir_edit', 'deleteRoute' => 'app_admin_savoir_delete', 'deleteTokenPrefix' => 'delete-savoir-', 'displayProperty' => 'title', 'subtitleProperty' => 'content', 'countProperty' => null]); }

    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { $savoir = (new Savoir())->setCreatedAt(new \DateTimeImmutable())->setIsFocus(false); return $this->save($savoir, $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Savoir $savoir, Request $request, EntityManagerInterface $em): Response { return $this->save($savoir, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Savoir $savoir, Request $request, EntityManagerInterface $em): Response { if ($this->isCsrfTokenValid('delete-savoir-'.$savoir->getId(), $request->getPayload()->getString('_token'))) { $em->remove($savoir); $em->flush(); $this->addFlash('success', 'Le savoir a été supprimé.'); } else { $this->addFlash('error', 'Jeton de suppression invalide.'); } return $this->redirectToRoute('app_admin_savoir_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Savoir $savoir, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(SavoirType::class, $savoir)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($savoir); $em->flush(); $this->addFlash('success', 'Le savoir a été enregistré.'); return $this->redirectToRoute('app_admin_savoir_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouveau Savoir préservé', 'editTitle' => 'Modifier le Savoir préservé', 'userStory' => 'US49 — Gérer les savoirs préservés', 'indexRoute' => 'app_admin_savoir_index']); }
}
