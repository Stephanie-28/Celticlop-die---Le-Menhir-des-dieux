<?php

namespace App\Repository;

use App\Entity\Savoir;
use App\Enum\SavoirEditorialType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Savoir>
 */
class SavoirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Savoir::class);
    }

    public function clearFocusExcept(?int $savoirId): void
    {
        $query = $this->createQueryBuilder('s')
            ->update()
            ->set('s.isFocus', ':disabled')
            ->where('s.isFocus = :enabled')
            ->setParameter('disabled', false)
            ->setParameter('enabled', true);

        if ($savoirId !== null) {
            $query
                ->andWhere('s.id != :savoirId')
                ->setParameter('savoirId', $savoirId);
        }

        $query->getQuery()->execute();
    }

    /** @return Savoir[] */
    public function findByEditorialType(SavoirEditorialType $type): array
    {
        return $this->findBy(['editorialType' => $type], ['createdAt' => 'DESC', 'title' => 'ASC']);
    }

    public function findFocus(): ?Savoir
    {
        return $this->findOneBy(['isFocus' => true], ['createdAt' => 'DESC']);
    }

    //    /**
    //     * @return Savoir[] Returns an array of Savoir objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Savoir
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
