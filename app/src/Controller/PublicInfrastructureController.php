<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Dieu;
use App\Entity\Symbole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicInfrastructureController extends AbstractController
{
    #[Route('/animaux/{id}', name: 'app_public_animal_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function animal(Animal $animal): Response
    {
        return $this->render('public/content/relic_show.html.twig', [
            'item' => $animal,
            'categoryLabel' => 'Animal sacré',
            'imageDirectory' => 'uploads/animaux/',
            'associatedGods' => $this->visibleGods($animal->getDieux()->toArray()),
            'adminEditRoute' => 'app_admin_animal_edit',
        ]);
    }

    #[Route('/symboles/{id}', name: 'app_public_symbole_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function symbole(Symbole $symbole): Response
    {
        return $this->render('public/content/relic_show.html.twig', [
            'item' => $symbole,
            'categoryLabel' => 'Symbole sacré',
            'imageDirectory' => 'uploads/symboles/',
            'associatedGods' => $this->visibleGods($symbole->getDieux()->toArray()),
            'adminEditRoute' => 'app_admin_symbole_edit',
        ]);
    }

    /**
     * @param list<Dieu> $gods
     * @return list<Dieu>
     */
    private function visibleGods(array $gods): array
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $gods;
        }

        return array_values(array_filter($gods, static fn (Dieu $dieu): bool => $dieu->isVisible()));
    }
}
