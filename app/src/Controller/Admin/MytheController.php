<?php

namespace App\Controller\Admin;

use App\Entity\Mythe;
use App\Form\Admin\MytheType;
use App\Repository\MytheRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/mythes', name: 'app_admin_mythe_')]
final class MytheController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(MytheRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['createdAt' => 'DESC']), 'title' => 'Mythes', 'description' => 'Administrer les récits, leurs catégories et leurs divinités.', 'userStory' => 'US47 — Gérer les mythes', 'newRoute' => 'app_admin_mythe_new', 'newLabel' => 'Ajouter un Mythe', 'editRoute' => 'app_admin_mythe_edit', 'deleteRoute' => 'app_admin_mythe_delete', 'deleteTokenPrefix' => 'delete-mythe-', 'displayProperty' => 'title', 'subtitleProperty' => 'content', 'countProperty' => 'chroniques']); }

    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { $mythe = (new Mythe())->setCreatedAt(new \DateTimeImmutable()); return $this->save($mythe, $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Mythe $mythe, Request $request, EntityManagerInterface $em): Response { return $this->save($mythe, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Mythe $mythe, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-mythe-'.$mythe->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } elseif (!$mythe->getChroniques()->isEmpty()) { $this->addFlash('error', 'Supprimez d’abord les chroniques liées à ce mythe.'); } else { try { $em->remove($mythe); $em->flush(); $this->addFlash('success', 'Le mythe a été supprimé.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Ce mythe est encore utilisé.'); } } return $this->redirectToRoute('app_admin_mythe_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Mythe $mythe, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(MytheType::class, $mythe)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($mythe); $em->flush(); $this->addFlash('success', 'Le mythe a été enregistré.'); return $this->redirectToRoute('app_admin_mythe_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouveau Mythe', 'editTitle' => 'Modifier le Mythe', 'userStory' => 'US47 — Gérer les mythes', 'indexRoute' => 'app_admin_mythe_index']); }
}
