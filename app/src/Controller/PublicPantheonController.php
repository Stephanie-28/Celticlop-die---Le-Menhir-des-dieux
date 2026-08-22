<?php

namespace App\Controller;

use App\Repository\DieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicPantheonController extends AbstractController
{
    #[Route('/pantheon', name: 'app_public_pantheon_all', methods: ['GET'])]
    public function all(DieuRepository $repository): Response
    {
        return $this->renderPantheon($repository, null, 'Toutes les divinités');
    }

    #[Route('/pantheon/gaulois', name: 'app_public_pantheon_gaulois', methods: ['GET'])]
    public function gaulish(DieuRepository $repository): Response
    {
        return $this->renderPantheon($repository, 'gaulois', 'Panthéon gaulois');
    }

    #[Route('/pantheon/gallois', name: 'app_public_pantheon_gallois', methods: ['GET'])]
    public function welsh(DieuRepository $repository): Response
    {
        return $this->renderPantheon($repository, 'gallois', 'Panthéon gallois');
    }

    #[Route('/pantheon/irlandais', name: 'app_public_pantheon_irlandais', methods: ['GET'])]
    public function irish(DieuRepository $repository): Response
    {
        return $this->renderPantheon($repository, 'irlandais', 'Panthéon irlandais');
    }

    private function renderPantheon(DieuRepository $repository, ?string $pantheon, string $pageTitle): Response
    {
        $queryBuilder = $repository->createQueryBuilder('d')
            ->andWhere('d.isVisible = :visible')
            ->setParameter('visible', true)
            ->orderBy('d.name', 'ASC');

        if ($pantheon !== null) {
            $queryBuilder
                ->innerJoin('d.pantheons', 'p')
                ->andWhere('LOWER(p.title) LIKE :pantheon')
                ->setParameter('pantheon', '%'.$pantheon.'%')
                ->distinct();
        }

        return $this->render('public/pantheon/index.html.twig', [
            'dieux' => $queryBuilder->getQuery()->getResult(),
            'activePantheon' => $pantheon ?? 'all',
            'pageTitle' => $pageTitle,
        ]);
    }
}
