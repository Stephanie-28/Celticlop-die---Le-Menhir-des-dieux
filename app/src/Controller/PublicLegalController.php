<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class PublicLegalController extends AbstractController
{
    #[Route('/accessibilite', name: 'app_public_accessibility', methods: ['GET'])]
    public function accessibility(): Response
    {
        return $this->render('public/legal/accessibility.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'app_public_privacy', methods: ['GET'])]
    public function privacy(): Response
    {
        return $this->render('public/legal/privacy.html.twig');
    }
}
