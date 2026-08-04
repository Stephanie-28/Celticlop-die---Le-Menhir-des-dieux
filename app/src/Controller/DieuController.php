<?php

namespace App\Controller;

use App\Entity\Dieu;
use App\Form\DieuType;
use App\Repository\DieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dieu')]
final class DieuController extends AbstractController
{
    #[Route(name: 'app_dieu_index', methods: ['GET'])]
    public function index(DieuRepository $dieuRepository): Response
    {
        return $this->render('dieu/index.html.twig', [
            'dieux' => $dieuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dieu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dieu = new Dieu();
        $form = $this->createForm(DieuType::class, $dieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dieu);
            $entityManager->flush();

            return $this->redirectToRoute('app_dieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dieu/new.html.twig', [
            'dieu' => $dieu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dieu_show', methods: ['GET'])]
    public function show(Dieu $dieu): Response
    {
        return $this->render('dieu/show.html.twig', [
            'dieu' => $dieu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dieu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dieu $dieu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DieuType::class, $dieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dieu/edit.html.twig', [
            'dieu' => $dieu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dieu_delete', methods: ['POST'])]
    public function delete(Request $request, Dieu $dieu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dieu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dieu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dieu_index', [], Response::HTTP_SEE_OTHER);
    }
}
