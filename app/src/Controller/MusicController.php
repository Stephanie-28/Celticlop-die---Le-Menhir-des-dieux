<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Music;
use App\Entity\User;
use App\Enum\FavoriteEntityType;
use App\Repository\FavoriteRepository;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class MusicController extends AbstractController
{
    #[Route('/musiques', name: 'app_public_music_index', methods: ['GET'])]
    public function index(MusicRepository $musicRepository, FavoriteRepository $favoriteRepository): Response
    {
        $playlistIds = [];
        $user = $this->getUser();
        if ($user instanceof User) {
            $playlistIds = array_map(
                static fn (Favorite $favorite): int => $favorite->getEntityId(),
                $favoriteRepository->findMusicFavoritesForUser($user),
            );
        }

        return $this->render('music/index.html.twig', [
            'musics' => $musicRepository->findBy([], ['title' => 'ASC']),
            'playlistIds' => $playlistIds,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/ma-playlist', name: 'app_public_music_playlist', methods: ['GET'])]
    public function playlist(MusicRepository $musicRepository, FavoriteRepository $favoriteRepository): Response
    {
        $user = $this->requireUser();
        $favorites = $favoriteRepository->findMusicFavoritesForUser($user);
        $musicById = [];

        if ($favorites !== []) {
            foreach ($musicRepository->findBy(['id' => array_map(
                static fn (Favorite $favorite): int => $favorite->getEntityId(),
                $favorites,
            )]) as $music) {
                $musicById[$music->getId()] = $music;
            }
        }

        $musics = [];
        foreach ($favorites as $favorite) {
            if (isset($musicById[$favorite->getEntityId()])) {
                $musics[] = $musicById[$favorite->getEntityId()];
            }
        }

        return $this->render('music/playlist.html.twig', ['musics' => $musics]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/musiques/{id}/playlist/ajouter', name: 'app_public_music_add', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function add(
        Music $music,
        Request $request,
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->requireUser();
        if (!$this->isCsrfTokenValid('playlist-add-'.$music->getId(), $request->getPayload()->getString('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        if ($favoriteRepository->findMusicFavorite($user, $music->getId()) instanceof Favorite) {
            $this->addFlash('playlist_info', 'Cette musique se trouve déjà dans ta playlist.');
        } else {
            $favorite = (new Favorite())
                ->setUser($user)
                ->setEntityType(FavoriteEntityType::MUSIC)
                ->setEntityId($music->getId())
                ->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($favorite);
            $entityManager->flush();
            $this->addFlash('playlist_success', sprintf('« %s » a rejoint ta playlist.', $music->getTitle()));
        }

        return $this->redirectToRoute('app_public_music_index', status: Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/musiques/{id}/playlist/retirer', name: 'app_public_music_remove', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function remove(
        Music $music,
        Request $request,
        FavoriteRepository $favoriteRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->requireUser();
        if (!$this->isCsrfTokenValid('playlist-remove-'.$music->getId(), $request->getPayload()->getString('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        $favorite = $favoriteRepository->findMusicFavorite($user, $music->getId());
        if ($favorite instanceof Favorite) {
            $entityManager->remove($favorite);
            $entityManager->flush();
            $this->addFlash('playlist_success', sprintf('« %s » a été retirée de ta playlist.', $music->getTitle()));
        } else {
            $this->addFlash('playlist_info', 'Cette musique ne se trouve pas dans ta playlist.');
        }

        $targetRoute = $request->request->getString('_from') === 'playlist'
            ? 'app_public_music_playlist'
            : 'app_public_music_index';

        return $this->redirectToRoute($targetRoute, status: Response::HTTP_SEE_OTHER);
    }

    private function requireUser(): User
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $user;
    }
}
