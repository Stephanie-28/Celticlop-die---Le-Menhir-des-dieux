<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\Dieu;
use App\Entity\Favorite;
use App\Entity\Music;
use App\Entity\Mythe;
use App\Entity\Savoir;
use App\Entity\Symbole;
use App\Entity\User;
use App\Enum\FavoriteEntityType;
use App\Repository\FavoriteRepository;
use Doctrine\Persistence\ManagerRegistry;

final class FavoriteCatalog
{
    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly ManagerRegistry $doctrine,
    ) {
    }

    /**
     * @return array<string, array{label: string, items: list<array<string, mixed>>}>
     */
    public function forUser(User $user): array
    {
        $groups = [
            'dieux' => ['label' => 'Mes Dieux', 'items' => []],
            'mythes' => ['label' => 'Mes Mythes', 'items' => []],
            'symboles' => ['label' => 'Mes Symboles', 'items' => []],
            'animaux' => ['label' => 'Mes Animaux', 'items' => []],
            'savoirs' => ['label' => 'Mes Savoirs', 'items' => []],
            'musiques' => ['label' => 'Mes Musiques', 'items' => []],
        ];

        foreach ($this->favoriteRepository->findBy(['user' => $user], ['createdAt' => 'DESC']) as $favorite) {
            $item = $this->resolve($favorite);
            if ($item !== null) {
                $groups[$item['group']]['items'][] = $item;
            }
        }

        return $groups;
    }

    /** @return array<string, mixed>|null */
    private function resolve(Favorite $favorite): ?array
    {
        $type = $favorite->getEntityType();
        $configuration = match ($type) {
            FavoriteEntityType::DIEU => [Dieu::class, 'dieux', 'name', 'img', 'uploads/dieux/', 'app_public_dieu_show'],
            FavoriteEntityType::MYTHE => [Mythe::class, 'mythes', 'title', 'img', 'uploads/mythes/', null],
            FavoriteEntityType::SYMBOLE => [Symbole::class, 'symboles', 'name', 'img', 'uploads/symboles/', 'app_public_symbole_show'],
            FavoriteEntityType::ANIMAL => [Animal::class, 'animaux', 'name', 'img', 'uploads/animaux/', 'app_public_animal_show'],
            FavoriteEntityType::SAVOIR => [Savoir::class, 'savoirs', 'title', 'img', 'uploads/savoirs/', 'app_public_savoir_show'],
            FavoriteEntityType::MUSIC => [Music::class, 'musiques', 'title', null, null, null],
            default => null,
        };

        if ($configuration === null) {
            return null;
        }

        [$class, $group, $labelProperty, $imageProperty, $imagePrefix, $route] = $configuration;
        $entity = $this->doctrine->getManagerForClass($class)?->find($class, $favorite->getEntityId());
        if ($entity === null || ($entity instanceof Dieu && !$entity->isVisible())) {
            return null;
        }

        $labelGetter = 'get'.ucfirst($labelProperty);
        $imageGetter = $imageProperty === null ? null : 'get'.ucfirst($imageProperty);
        $image = $imageGetter === null ? null : $entity->{$imageGetter}();

        return [
            'group' => $group,
            'id' => $entity->getId(),
            'label' => $entity->{$labelGetter}(),
            'image' => $image ? $imagePrefix.$image : null,
            'route' => $route,
            'createdAt' => $favorite->getCreatedAt(),
        ];
    }
}
