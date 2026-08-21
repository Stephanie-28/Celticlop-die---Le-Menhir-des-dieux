<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\FavoriteRepository;
use App\Service\AvatarUploader;
use App\Service\InitiationPath;
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
        InitiationPath $initiationPath,
    ): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $currentRank = $initiationPath->forFavoriteCount($favoriteRepository->countForUser($user));
        $ceremony = null;

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
            'initiationCeremony' => $ceremony,
        ]);
    }
}
