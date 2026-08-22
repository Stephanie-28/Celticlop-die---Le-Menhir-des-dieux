<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PublicInfrastructureController extends AbstractController
{
    #[Route('/animaux/{id}', name: 'app_public_animal_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    #[Route('/symboles/{id}', name: 'app_public_symbole_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function pendingPublicRecord(): RedirectResponse
    {
        return $this->redirectToRoute('app_public_pantheon_all');
    }
}
