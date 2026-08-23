<?php

namespace App\Controller\Admin;

use App\Entity\Music;
use App\Form\Admin\MusicType;
use App\Repository\MusicRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/musiques', name: 'app_admin_music_')]
final class MusicController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(MusicRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['title' => 'ASC']), 'title' => 'Bibliothèque musicale', 'description' => 'Administrer les pistes musicales et leur éventuelle divinité.', 'userStory' => 'US50 — Gérer la bibliothèque musicale', 'newRoute' => 'app_admin_music_new', 'newLabel' => 'Ajouter une Musique', 'editRoute' => 'app_admin_music_edit', 'deleteRoute' => 'app_admin_music_delete', 'deleteTokenPrefix' => 'delete-music-', 'displayProperty' => 'title', 'subtitleProperty' => 'artist', 'countProperty' => null]); }

    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { return $this->save(new Music(), $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Music $music, Request $request, EntityManagerInterface $em): Response { return $this->save($music, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Music $music, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-music-'.$music->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } else { try { if ($music->getDieu()) { $music->getDieu()->setMusic(null); } $em->remove($music); $em->flush(); $this->addFlash('success', 'La musique a été supprimée.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Cette musique est encore utilisée.'); } } return $this->redirectToRoute('app_admin_music_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Music $music, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(MusicType::class, $music)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($music); $em->flush(); $this->addFlash('success', 'La musique a été enregistrée.'); return $this->redirectToRoute('app_admin_music_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouvelle Musique', 'editTitle' => 'Modifier la Musique', 'userStory' => 'US50 — Gérer la bibliothèque musicale', 'indexRoute' => 'app_admin_music_index']); }
}
