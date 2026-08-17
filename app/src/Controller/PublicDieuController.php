<?php

namespace App\Controller;

use App\Entity\Dieu;
use App\Repository\DieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicDieuController extends AbstractController
{
    #[Route('/dieux/{id}', name: 'app_public_dieu_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(Dieu $dieu, DieuRepository $dieuRepository): Response
    {
        $dagdaContext = null;
        $usesUnifiedLayout = in_array($dieu->getName(), [
            'Morrigan',
            'Atepomarus',
            'Rhiannon',
            'Arawn',
        ], true);
        $unifiedContext = null;

        if ($usesUnifiedLayout) {
            $pantheon = $dieu->getPantheons()->first();
            $nextDieu = null;

            if ($pantheon !== false) {
                $nextDieu = $dieuRepository->createQueryBuilder('nextDieu')
                    ->innerJoin('nextDieu.pantheons', 'pantheon')
                    ->andWhere('pantheon.id = :pantheonId')
                    ->andWhere('nextDieu.id > :currentId')
                    ->setParameter('pantheonId', $pantheon->getId())
                    ->setParameter('currentId', $dieu->getId())
                    ->orderBy('nextDieu.id', 'ASC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
            }

            $unifiedContext = [
                'nextDieu' => $nextDieu,
            ];
        }

        if (mb_strtolower($dieu->getName()) === 'dagda') {
            $associatedDeities = [];
            $genealogy = [];
            $cochon = $dieu->getAnimaux()->findFirst(
                static fn (int $key, $animal): bool => $animal->getId() === 11,
            );
            $harpe = $dieu->getSymboles()->findFirst(
                static fn (int $key, $symbole): bool => $symbole->getId() === 6,
            );
            $chaudron = $dieu->getSymboles()->findFirst(
                static fn (int $key, $symbole): bool => $symbole->getId() === 5,
            );
            $lorgMor = $dieu->getSymboles()->findFirst(
                static fn (int $key, $symbole): bool => $symbole->getId() === 7,
            );
            $chene = $dieu->getSymboles()->findFirst(
                static fn (int $key, $symbole): bool => $symbole->getId() === 13,
            );

            foreach ([
                [
                    'name' => 'Morrigan',
                    'relation' => 'Épouse / compagne',
                    'detail' => 'Union rituelle à Samain',
                    'associatedRelation' => 'Union rituelle à Samain',
                ],
                [
                    'name' => 'Boann',
                    'relation' => 'Amante',
                    'detail' => 'Mère d’Aengus Óg',
                    'associatedRelation' => null,
                ],
                [
                    'name' => 'Brigid',
                    'relation' => 'Fille',
                    'detail' => null,
                    'associatedRelation' => 'Fille de Dagda',
                ],
                [
                    'name' => 'Aengus Óg',
                    'relation' => 'Fils de Dagda et Boann',
                    'detail' => null,
                    'associatedRelation' => 'Fils de Dagda',
                ],
            ] as $association) {
                $associatedDieu = $dieuRepository->findOneBy(['name' => $association['name']]);

                if ($associatedDieu instanceof Dieu) {
                    $genealogy[] = [
                        'dieu' => $associatedDieu,
                        'relation' => $association['relation'],
                        'detail' => $association['detail'],
                    ];

                    if ($association['associatedRelation'] !== null) {
                        $associatedDeities[] = [
                            'dieu' => $associatedDieu,
                            'relation' => $association['associatedRelation'],
                        ];
                    }
                }
            }

            $nextDieu = $dieuRepository->createQueryBuilder('nextDieu')
                ->innerJoin('nextDieu.pantheons', 'pantheon')
                ->andWhere('pantheon.title = :pantheon')
                ->andWhere('nextDieu.id > :currentId')
                ->setParameter('pantheon', 'Panthéon irlandais')
                ->setParameter('currentId', $dieu->getId())
                ->orderBy('nextDieu.id', 'ASC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            $dagdaContext = [
                'associatedDeities' => $associatedDeities,
                'chene' => $chene ?: null,
                'chaudron' => $chaudron ?: null,
                'cochon' => $cochon ?: null,
                'genealogy' => $genealogy,
                'harpe' => $harpe ?: null,
                'lorgMor' => $lorgMor ?: null,
                'nextDieu' => $nextDieu,
            ];
        }

        return $this->render('public/dieu/show.html.twig', [
            'dieu' => $dieu,
            'dagdaContext' => $dagdaContext,
            'unifiedContext' => $unifiedContext,
            'usesUnifiedLayout' => $usesUnifiedLayout,
        ]);
    }
}
