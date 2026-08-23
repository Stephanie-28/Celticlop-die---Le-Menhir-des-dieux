<?php

namespace App\Controller\Admin;

use App\Entity\Chronique;
use App\Form\Admin\ChroniqueType;
use App\Repository\ChroniqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/chroniques', name: 'app_admin_chronique_')]
final class ChroniqueController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ChroniqueRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['publishedAt' => 'DESC']), 'title' => 'Chroniques', 'description' => 'Administrer les chroniques rattachées aux mythes existants.', 'userStory' => 'US48 — Gérer les chroniques', 'newRoute' => 'app_admin_chronique_new', 'newLabel' => 'Ajouter une Chronique', 'editRoute' => 'app_admin_chronique_edit', 'deleteRoute' => 'app_admin_chronique_delete', 'deleteTokenPrefix' => 'delete-chronique-', 'displayProperty' => 'title', 'subtitleProperty' => 'content', 'countProperty' => null]); }

    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { $chronique = (new Chronique())->setPublishedAt(new \DateTimeImmutable()); return $this->save($chronique, $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Chronique $chronique, Request $request, EntityManagerInterface $em): Response { return $this->save($chronique, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Chronique $chronique, Request $request, EntityManagerInterface $em): Response { if ($this->isCsrfTokenValid('delete-chronique-'.$chronique->getId(), $request->getPayload()->getString('_token'))) { $em->remove($chronique); $em->flush(); $this->addFlash('success', 'La chronique a été supprimée.'); } else { $this->addFlash('error', 'Jeton de suppression invalide.'); } return $this->redirectToRoute('app_admin_chronique_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Chronique $chronique, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(ChroniqueType::class, $chronique)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($chronique); $em->flush(); $this->addFlash('success', 'La chronique a été enregistrée.'); return $this->redirectToRoute('app_admin_chronique_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouvelle Chronique', 'editTitle' => 'Modifier la Chronique', 'userStory' => 'US48 — Gérer les chroniques', 'indexRoute' => 'app_admin_chronique_index']); }
}
