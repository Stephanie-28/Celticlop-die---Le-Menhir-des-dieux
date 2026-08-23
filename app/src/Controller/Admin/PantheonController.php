<?php

namespace App\Controller\Admin;

use App\Entity\Pantheons;
use App\Form\Admin\PantheonType;
use App\Repository\PantheonsRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/pantheons', name: 'app_admin_pantheon_')]
final class PantheonController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PantheonsRepository $repository): Response
    {
        return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['title' => 'ASC']), 'title' => 'Panthéons', 'description' => 'Administrer les origines mythologiques et leurs divinités.', 'userStory' => 'US44 — Gérer les panthéons', 'newRoute' => 'app_admin_pantheon_new', 'newLabel' => 'Ajouter un Panthéon', 'editRoute' => 'app_admin_pantheon_edit', 'deleteRoute' => 'app_admin_pantheon_delete', 'deleteTokenPrefix' => 'delete-pantheon-', 'displayProperty' => 'title', 'subtitleProperty' => 'description', 'countProperty' => 'dieux']);
    }

    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        return $this->save(new Pantheons(), $request, $em, true);
    }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Pantheons $pantheon, Request $request, EntityManagerInterface $em): Response
    {
        return $this->save($pantheon, $request, $em, false);
    }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Pantheons $pantheon, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete-pantheon-'.$pantheon->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Jeton de suppression invalide.');
        } else {
            try { $em->remove($pantheon); $em->flush(); $this->addFlash('success', 'Le panthéon a été supprimé.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Ce panthéon est encore utilisé.'); }
        }

        return $this->redirectToRoute('app_admin_pantheon_index', status: Response::HTTP_SEE_OTHER);
    }

    private function save(Pantheons $pantheon, Request $request, EntityManagerInterface $em, bool $isCreation): Response
    {
        $form = $this->createForm(PantheonType::class, $pantheon)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $em->persist($pantheon); $em->flush(); $this->addFlash('success', 'Le panthéon a été enregistré.'); return $this->redirectToRoute('app_admin_pantheon_index', status: Response::HTTP_SEE_OTHER); }

        return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouveau Panthéon', 'editTitle' => 'Modifier le Panthéon', 'userStory' => 'US44 — Gérer les panthéons', 'indexRoute' => 'app_admin_pantheon_index']);
    }
}
