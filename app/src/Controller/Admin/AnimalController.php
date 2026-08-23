<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\Admin\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/animaux', name: 'app_admin_animal_')]
final class AnimalController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(AnimalRepository $repository): Response { return $this->render('admin/content/index.html.twig', ['items' => $repository->findBy([], ['name' => 'ASC']), 'title' => 'Bestiaire', 'description' => 'Administrer les animaux sacrés et leurs divinités associées.', 'userStory' => 'US46 — Gérer le bestiaire', 'newRoute' => 'app_admin_animal_new', 'newLabel' => 'Ajouter un Animal sacré', 'editRoute' => 'app_admin_animal_edit', 'deleteRoute' => 'app_admin_animal_delete', 'deleteTokenPrefix' => 'delete-animal-', 'displayProperty' => 'name', 'subtitleProperty' => 'description', 'countProperty' => 'dieux']); }

    #[Route('/nouvel-animal', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response { return $this->save(new Animal(), $request, $em, true); }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Animal $animal, Request $request, EntityManagerInterface $em): Response { return $this->save($animal, $request, $em, false); }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Animal $animal, Request $request, EntityManagerInterface $em): Response { if (!$this->isCsrfTokenValid('delete-animal-'.$animal->getId(), $request->getPayload()->getString('_token'))) { $this->addFlash('error', 'Jeton de suppression invalide.'); } else { try { $em->remove($animal); $em->flush(); $this->addFlash('success', 'L’animal a été supprimé.'); } catch (ForeignKeyConstraintViolationException) { $this->addFlash('error', 'Cet animal est encore utilisé.'); } } return $this->redirectToRoute('app_admin_animal_index', status: Response::HTTP_SEE_OTHER); }

    private function save(Animal $animal, Request $request, EntityManagerInterface $em, bool $isCreation): Response { $form = $this->createForm(AnimalType::class, $animal)->handleRequest($request); if ($form->isSubmitted() && $form->isValid()) { $em->persist($animal); $em->flush(); $this->addFlash('success', 'L’animal a été enregistré.'); return $this->redirectToRoute('app_admin_animal_index', status: Response::HTTP_SEE_OTHER); } return $this->render('admin/content/form.html.twig', ['form' => $form, 'isCreation' => $isCreation, 'newTitle' => 'Nouvel Animal sacré', 'editTitle' => 'Modifier l’Animal sacré', 'userStory' => 'US46 — Gérer le bestiaire', 'indexRoute' => 'app_admin_animal_index']); }
}
