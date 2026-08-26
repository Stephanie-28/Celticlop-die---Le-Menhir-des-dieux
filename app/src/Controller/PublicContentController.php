<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Savoir;
use App\Entity\User;
use App\Enum\SavoirEditorialType;
use App\Repository\ChroniqueRepository;
use App\Repository\AnimalRepository;
use App\Repository\SavoirRepository;
use App\Repository\SymboleRepository;
use App\Service\FavoriteCatalog;
use App\Service\ArchiveCatalog;
use App\Service\SavoirDossierPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PublicContentController extends AbstractController
{
    #[Route('/archives-du-druide', name: 'app_public_savoir_index', methods: ['GET'])]
    public function savoirIndex(SavoirRepository $repository): Response
    {
        $dossierOrder = ['Parchemins Anciens', 'Alphabet Ogham', "Secrets d'Avalon", 'Prophéties', 'Sagesse Druidique'];
        $dossiersByTitle = [];
        foreach ($repository->findByEditorialType(SavoirEditorialType::DOSSIER) as $dossier) {
            $dossiersByTitle[$dossier->getTitle()] = $dossier;
        }

        return $this->render('public/content/savoirs.html.twig', [
            'dossiers' => array_values(array_filter(array_map(
                static fn (string $title): ?Savoir => $dossiersByTitle[$title] ?? null,
                $dossierOrder,
            ))),
            'focus' => $repository->findFocus(),
        ]);
    }

    #[Route('/archives-du-druide/bibliotheque', name: 'app_public_savoir_library', methods: ['GET'])]
    public function savoirLibrary(SavoirRepository $repository, ArchiveCatalog $archiveCatalog): Response
    {
        $officialSavoirs = $repository->findByEditorialType(SavoirEditorialType::OFFICIEL);
        $discoveries = $repository->findByEditorialType(SavoirEditorialType::DECOUVERTE);
        $dossiersByTitle = [];
        foreach ($repository->findByEditorialType(SavoirEditorialType::DOSSIER) as $dossier) {
            $dossiersByTitle[$dossier->getTitle()] = $dossier;
        }
        $dossiers = array_values(array_filter(array_map(
            static fn (string $title): ?Savoir => $dossiersByTitle[$title] ?? null,
            ['Parchemins Anciens', 'Alphabet Ogham', "Secrets d'Avalon", 'Prophéties', 'Sagesse Druidique'],
        )));

        return $this->render('public/content/savoir_library.html.twig', [
            'officialSavoirs' => $officialSavoirs,
            'discoveries' => $discoveries,
            'dossiers' => $dossiers,
            'catalog' => $archiveCatalog->build($officialSavoirs, $discoveries, $dossiers),
        ]);
    }

    #[Route('/archives-du-druide/{id}', name: 'app_public_savoir_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function savoirShow(Savoir $savoir, SavoirDossierPresenter $dossierPresenter): Response
    {
        return $this->render('public/content/savoir_show.html.twig', [
            'savoir' => $savoir,
            'dossierPresentation' => $dossierPresenter->present($savoir),
        ]);
    }

    #[Route('/chroniques-mythiques', name: 'app_public_chronique_index', methods: ['GET'])]
    public function chroniqueIndex(ChroniqueRepository $repository): Response
    {
        return $this->render('public/content/chroniques.html.twig', [
            'chroniques' => $repository->findBy([], ['publishedAt' => 'DESC']),
        ]);
    }

    #[Route('/chroniques-mythiques/{id}', name: 'app_public_chronique_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function chroniqueShow(Chronique $chronique): Response
    {
        return $this->render('public/content/chronique_show.html.twig', ['chronique' => $chronique]);
    }

    #[Route('/reliques', name: 'app_public_relique_index', methods: ['GET'])]
    public function reliques(SymboleRepository $symboleRepository, AnimalRepository $animalRepository): Response
    {
        return $this->render('public/content/reliques.html.twig', [
            'symboles' => $symboleRepository->findBy([], ['name' => 'ASC']),
            'animaux' => $animalRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/mon-sanctuaire', name: 'app_public_sanctuary', methods: ['GET'])]
    public function sanctuary(FavoriteCatalog $favoriteCatalog): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('public/content/sanctuary.html.twig', [
            'favoriteGroups' => $favoriteCatalog->forUser($user),
        ]);
    }
}
