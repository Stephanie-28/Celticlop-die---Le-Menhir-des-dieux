<?php

namespace App\Controller\Admin;

use App\Entity\Dieu;
use App\Form\Admin\DieuType;
use App\Repository\DieuRepository;
use App\Service\DeityPortraitUploader;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/divinites', name: 'app_admin_dieu_')]
final class DieuController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(DieuRepository $repository): Response
    {
        return $this->render('admin/dieu/index.html.twig', [
            'dieux' => $repository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, DeityPortraitUploader $uploader): Response
    {
        $dieu = new Dieu();
        $form = $this->createForm(DieuType::class, $dieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storePortrait($form->get('portraitFile')->getData(), $dieu, $uploader);
            $entityManager->persist($dieu);
            $entityManager->flush();
            $this->addFlash('success', sprintf('%s rejoint désormais les archives sacrées.', $dieu->getName()));

            return $this->redirectToRoute('app_public_dieu_show', ['id' => $dieu->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dieu/form.html.twig', ['dieu' => $dieu, 'form' => $form, 'isCreation' => true]);
    }

    #[Route('/{id}/modifier', name: 'edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    public function edit(Dieu $dieu, Request $request, EntityManagerInterface $entityManager, DeityPortraitUploader $uploader): Response
    {
        $form = $this->createForm(DieuType::class, $dieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storePortrait($form->get('portraitFile')->getData(), $dieu, $uploader);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La fiche de %s a été mise à jour.', $dieu->getName()));

            return $this->redirectToRoute('app_public_dieu_show', ['id' => $dieu->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dieu/form.html.twig', ['dieu' => $dieu, 'form' => $form, 'isCreation' => false]);
    }

    #[Route('/{id}/supprimer', name: 'delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function delete(Dieu $dieu, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-dieu-'.$dieu->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'La suppression a été refusée : le jeton de sécurité est invalide.');

            return $this->redirectToRoute('app_admin_dieu_index', status: Response::HTTP_SEE_OTHER);
        }

        if (!$dieu->getReponses()->isEmpty() || !$dieu->getQuizResults()->isEmpty()) {
            $this->addFlash('error', 'Cette divinité participe au Quiz ou à des résultats enregistrés. Supprimez d’abord ces dépendances.');

            return $this->redirectToRoute('app_admin_dieu_index', status: Response::HTTP_SEE_OTHER);
        }

        try {
            $entityManager->remove($dieu);
            $entityManager->flush();
            $this->addFlash('success', 'La divinité a été retirée des archives.');
        } catch (ForeignKeyConstraintViolationException) {
            $this->addFlash('error', 'Cette divinité est encore utilisée par d’autres contenus et ne peut pas être supprimée.');
        }

        return $this->redirectToRoute('app_admin_dieu_index', status: Response::HTTP_SEE_OTHER);
    }

    private function storePortrait(mixed $portrait, Dieu $dieu, DeityPortraitUploader $uploader): void
    {
        if ($portrait instanceof UploadedFile) {
            $dieu->setImg($uploader->upload($portrait));
        }
    }
}
