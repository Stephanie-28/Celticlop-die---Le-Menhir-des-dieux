<?php

namespace App\Controller\Admin;

use App\Entity\Symbole;
use App\Form\Admin\SymboleType;
use App\Repository\SymboleRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/symboles', name: 'app_admin_symbole_')]
final class SymboleController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SymboleRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['name' => 'ASC']), 'title' => 'Symboles', 'description' => 'Administrer les symboles et leurs liens avec les divinités.', 'userStory' => 'US45 — Gérer les symboles', 'newRoute' => 'app_admin_symbole_new', 'newLabel' => 'Ajouter un Symbole', 'editRoute' => 'app_admin_symbole_edit', 'deleteRoute' => 'app_admin_symbole_delete', 'deleteTokenPrefix' => 'delete-symbole-', 'displayProperty' => 'name', 'subtitleProperty' => 'description', 'countProperty' => 'dieux']); }

    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { return $this->save(new Symbole(), $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Symbole $symbole, Request $request, EntityManagerInterface $em): Response { return $this->save($symbole, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Symbole $symbole, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-symbole-'.$symbole->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } else { try { $em->remove($symbole); $em->flush(); $this->addFlash('success', 'Le symbole a été supprimé.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Ce symbole est encore utilisé.'); } } return $this->redirectToRoute('app_admin_symbole_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Symbole $symbole, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(SymboleType::class, $symbole)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($symbole); $em->flush(); $this->addFlash('success', 'Le symbole a été enregistré.'); return $this->redirectToRoute('app_admin_symbole_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouveau Symbole', 'editTitle' => 'Modifier le Symbole', 'userStory' => 'US45 — Gérer les symboles', 'indexRoute' => 'app_admin_symbole_index']); }
}
