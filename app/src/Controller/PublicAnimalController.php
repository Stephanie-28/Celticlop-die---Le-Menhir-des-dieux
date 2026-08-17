<?php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicAnimalController extends AbstractController
{
    #[Route('/animaux/{id}', name: 'app_public_animal_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        $animalChronicle = null;

        if ($animal->getId() === 11) {
            $animalChronicle = [
                'paragraphs' => [
                    'Dans les récits celtiques ici réunis, le cochon et le porc apparaissent dans plusieurs contextes liés au banquet, à l’abondance, à l’Autre Monde ou à la métamorphose. Ces fonctions ne décrivent pas un animal merveilleux unique : elles appartiennent à des traditions et à des épisodes distincts.',
                    'Auprès du Dagda, les cochons prennent place parmi les symboles d’une divinité de la fertilité et de l’abondance. Son chaudron nourrit sans fin les convives, tandis que son immense appétit donne au banquet une place particulière dans ses récits. Le porc rejoint ainsi un univers nourricier fait de prospérité, de nourriture partagée et de richesses capables de soutenir le peuple.',
                    'Le récit de Manannán mac Lir attribue à son propre cochon un pouvoir plus précis. L’animal peut être consommé, revenir à la vie et nourrir de nouveau les convives le jour suivant. Ce renouvellement merveilleux appartient à la possession de Manannán et prolonge le thème du banquet de l’Autre Monde, où la nourriture peut se renouveler sans s’épuiser.',
                    'Avec Cian, le lien est d’une autre nature. Père de Lugh et guerrier des Tuatha Dé Danann, Cian rencontre les fils de Tuireann sous une forme porcine avant d’être tué. Le cochon n’est donc pas ici une possession nourricière, mais une forme prise au cours d’une métamorphose.',
                    'Ces associations montrent trois usages qu’il faut garder distincts : l’abondance et le banquet dans l’univers du Dagda, l’animal merveilleux qui nourrit les convives auprès de Manannán, et la transformation de Cian. La fiche du Cochon les rassemble sans attribuer à tous les cochons mythologiques les propriétés propres à chacun de ces récits.',
                ],
                'highlight' => 'Animal du banquet, de l’abondance ou de la métamorphose selon les récits, le cochon occupe plusieurs fonctions distinctes dans les traditions celtiques.',
            ];
        }

        return $this->render('public/animal/show.html.twig', [
            'animal' => $animal,
            'animalChronicle' => $animalChronicle,
        ]);
    }
}
