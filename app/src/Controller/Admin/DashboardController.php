<?php

namespace App\Controller\Admin;

use App\Repository\AnimalRepository;
use App\Repository\ChroniqueRepository;
use App\Repository\DieuRepository;
use App\Repository\MusicRepository;
use App\Repository\MytheRepository;
use App\Repository\PantheonsRepository;
use App\Repository\QuestionRepository;
use App\Repository\SavoirRepository;
use App\Repository\SymboleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard', methods: ['GET'])]
    public function index(
        DieuRepository $dieuRepository,
        PantheonsRepository $pantheonsRepository,
        SymboleRepository $symboleRepository,
        AnimalRepository $animalRepository,
        MytheRepository $mytheRepository,
        ChroniqueRepository $chroniqueRepository,
        SavoirRepository $savoirRepository,
        MusicRepository $musicRepository,
        QuestionRepository $questionRepository,
    ): Response {
        return $this->render('admin/dashboard/index.html.twig', [
            'statistics' => [
                ['key' => 'deities', 'label' => 'Divinités', 'count' => $dieuRepository->count([])],
                ['key' => 'pantheons', 'label' => 'Panthéons', 'count' => $pantheonsRepository->count([])],
                ['key' => 'symbols', 'label' => 'Symboles', 'count' => $symboleRepository->count([])],
                ['key' => 'animals', 'label' => 'Animaux', 'count' => $animalRepository->count([])],
                ['key' => 'myths', 'label' => 'Mythes', 'count' => $mytheRepository->count([])],
                ['key' => 'chronicles', 'label' => 'Chroniques', 'count' => $chroniqueRepository->count([])],
                ['key' => 'knowledge', 'label' => 'Savoirs préservés', 'count' => $savoirRepository->count([])],
                ['key' => 'music', 'label' => 'Musiques', 'count' => $musicRepository->count([])],
                ['key' => 'quiz', 'label' => 'Questions Quiz', 'count' => $questionRepository->count([])],
            ],
        ]);
    }
}
