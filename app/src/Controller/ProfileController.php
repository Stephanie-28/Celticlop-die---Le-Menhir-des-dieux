<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\FavoriteRepository;
use App\Service\AvatarUploader;
use App\Service\InitiationPath;
use App\Service\FavoriteCatalog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        EntityManagerInterface $entityManager,
        AvatarUploader $avatarUploader,
        FavoriteRepository $favoriteRepository,
        FavoriteCatalog $favoriteCatalog,
        InitiationPath $initiationPath,
    ): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $currentRank = $initiationPath->forFavoriteCount($favoriteRepository->countForUser($user));
        $ceremony = null;
        $selectedTitleLevel = $user->getSelectedInitiationTitleLevel();

        if ($selectedTitleLevel !== null && ($selectedTitleLevel > $currentRank['level'] || $initiationPath->forLevel($selectedTitleLevel) === null)) {
            $user->setSelectedInitiationTitleLevel(null);
            $selectedTitleLevel = null;
            $entityManager->flush();
        }

        $displayedRank = $selectedTitleLevel === null
            ? $currentRank
            : $initiationPath->forLevel($selectedTitleLevel) ?? $currentRank;

        if ($request->isMethod('GET')) {
            $lastPresentedLevel = $user->getLastPresentedInitiationLevel();

            if ($lastPresentedLevel === null) {
                $user->setLastPresentedInitiationLevel($currentRank['level']);
                $entityManager->flush();
            } elseif ($lastPresentedLevel !== $currentRank['level']) {
                $ceremony = [
                    'direction' => $initiationPath->changeDirection($lastPresentedLevel, $currentRank['level']),
                    'rank' => $currentRank,
                ];
                $user->setLastPresentedInitiationLevel($currentRank['level']);
                $entityManager->flush();
            }
        }

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatarFile')->getData();

            try {
                if ($avatarFile instanceof UploadedFile) {
                    $user->setAvatar($avatarUploader->upload($avatarFile));
                }

                $entityManager->flush();
                $this->addFlash('profile_success', 'Tes changements ont été confiés au Sanctuaire.');

                return $this->redirectToRoute('app_profile');
            } catch (\InvalidArgumentException|\RuntimeException $exception) {
                $form->get('avatarFile')->addError(new FormError($exception->getMessage()));
            }
        }

        return $this->render('profile/show.html.twig', [
            'profileUser' => $user,
            'profileForm' => $form,
            'openSanctuary' => $form->isSubmitted() && !$form->isValid(),
            'initiationRanks' => $initiationPath->all(),
            'currentInitiationRank' => $currentRank,
            'displayedInitiationRank' => $displayedRank,
            'initiationCeremony' => $ceremony,
            'favoriteGroups' => $favoriteCatalog->forUser($user),
        ]);
    }

    #[Route('/profil/titre-initiatique/{level<\d+>}', name: 'app_profile_select_initiation_title', methods: ['POST'])]
    public function selectInitiationTitle(
        int $level,
        Request $request,
        EntityManagerInterface $entityManager,
        FavoriteRepository $favoriteRepository,
        InitiationPath $initiationPath,
    ): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('select-initiation-title-'.$level, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $currentRank = $initiationPath->forFavoriteCount($favoriteRepository->countForUser($user));
        $requestedRank = $initiationPath->forLevel($level);

        if ($requestedRank === null || !$initiationPath->canSelectTitle($level, $currentRank['level'])) {
            throw $this->createAccessDeniedException('Ce titre initiatique n’est pas encore débloqué.');
        }

        $user->setSelectedInitiationTitleLevel($level);
        $entityManager->flush();
        $this->addFlash('profile_success', sprintf('Le titre « %s » accompagne désormais ton Profil.', $requestedRank['title']));

        return $this->redirectToRoute('app_profile');
    }
}
