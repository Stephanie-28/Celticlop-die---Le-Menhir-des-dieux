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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
        UserPasswordHasherInterface $passwordHasher,
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

        if ($form->isSubmitted()) {
            $currentPassword = (string) $form->get('currentPassword')->getData();
            $newPassword = (string) $form->get('plainPassword')->getData();

            if ($newPassword !== '' && $currentPassword === '') {
                $form->get('currentPassword')->addError(new FormError('Saisis ton mot de passe actuel.'));
            } elseif ($newPassword !== '' && !$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $form->get('currentPassword')->addError(new FormError('Le mot de passe actuel est incorrect.'));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatarFile')->getData();
            $newPassword = (string) $form->get('plainPassword')->getData();

            try {
                if ($avatarFile instanceof UploadedFile) {
                    $user->setAvatar($avatarUploader->upload($avatarFile));
                }

                if ($newPassword !== '') {
                    $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
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

    #[Route('/profil/parametres-du-clan', name: 'app_profile_settings', methods: ['GET'])]
    public function settings(): Response
    {
        return $this->render('profile/settings.html.twig');
    }

    #[Route('/profil/parametres-du-clan/supprimer', name: 'app_profile_delete_account', methods: ['POST'])]
    public function deleteAccount(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        TokenStorageInterface $tokenStorage,
        AvatarUploader $avatarUploader,
    ): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('delete-account', (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $confirmation = trim((string) $request->request->get('confirmation'));
        $password = (string) $request->request->get('password');
        if ($confirmation !== 'SUPPRIMER' || !$passwordHasher->isPasswordValid($user, $password)) {
            $this->addFlash('settings_error', 'La confirmation ou le mot de passe est incorrect. Le compte n’a pas été supprimé.');

            return $this->redirectToRoute('app_profile_settings');
        }

        $avatar = $user->getAvatar();
        foreach ($user->getFavorites()->toArray() as $favorite) {
            $entityManager->remove($favorite);
        }
        foreach ($user->getQuizResults()->toArray() as $quizResult) {
            $entityManager->remove($quizResult);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        $avatarUploader->remove($avatar);

        $tokenStorage->setToken(null);
        $request->getSession()->invalidate();

        return $this->redirectToRoute('app_home');
    }
}
