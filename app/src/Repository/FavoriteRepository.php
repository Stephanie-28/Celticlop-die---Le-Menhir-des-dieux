<?php

namespace App\Repository;

use App\Entity\Favorite;
use App\Entity\User;
use App\Enum\FavoriteEntityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favorite>
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

    public function countForUser(User $user): int
    {
        return $this->count(['user' => $user]);
    }

    public function findMusicFavorite(User $user, int $musicId): ?Favorite
    {
        return $this->findOneBy([
            'user' => $user,
            'entityType' => FavoriteEntityType::MUSIC,
            'entityId' => $musicId,
        ]);
    }

    /**
     * @return Favorite[]
     */
    public function findMusicFavoritesForUser(User $user): array
    {
        return $this->findBy(
            ['user' => $user, 'entityType' => FavoriteEntityType::MUSIC],
            ['createdAt' => 'DESC'],
        );
    }

    //    /**
    //     * @return Favorite[] Returns an array of Favorite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Favorite
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
