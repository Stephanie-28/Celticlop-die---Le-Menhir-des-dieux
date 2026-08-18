<?php

namespace App\Controller;

use App\Entity\Dieu;
use App\Repository\AnimalRepository;
use App\Repository\DieuRepository;
use App\Repository\SymboleRepository;
use App\Service\DeityEditorialCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicDieuController extends AbstractController
{
    #[Route('/dieux/{id}', name: 'app_public_dieu_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(
        Dieu $dieu,
        DieuRepository $dieuRepository,
        AnimalRepository $animalRepository,
        SymboleRepository $symboleRepository,
        DeityEditorialCatalog $editorialCatalog,
    ): Response
    {
        $dagdaContext = null;
        $publicPantheon = $dieu->getPantheons()->findFirst(
            static fn (int $key, $pantheon): bool => in_array($pantheon->getTitle(), [
                'Panthéon irlandais',
                'Panthéon gaulois',
                'Panthéon gallois',
            ], true),
        );
        $usesUnifiedLayout = $publicPantheon !== null;
        $unifiedContext = null;

        if ($usesUnifiedLayout) {
            $pantheon = $publicPantheon;
            $nextDieu = null;
            $associatedDeities = [];
            $genealogy = [];
            $editorialProfile = match ($dieu->getName()) {
                'Morrigan' => [
                    'chronicleParagraphs' => [
                        'Morrigan, « la grande reine », est une déesse irlandaise liée à la guerre, au destin et à la mort sur le champ de bataille.',
                        'Elle est souvent présentée comme une triade associée à Badb, Macha et Nemain. Sous la forme d’une corneille ou d’un corbeau, elle annonce l’issue des combats.',
                        'Les récits la montrent notamment lavant les armes sanglantes de Cúchulainn avant sa mort.',
                        'Au moment de Samain, Morrigan s’unit rituellement à Dagda afin de lui accorder la victoire contre les Fomoires.',
                    ],
                    'chronicleHighlight' => 'Grande reine, figure guerrière et prophétique, Morrigan annonce l’issue des combats et accompagne le passage vers la mort.',
                    'thematicSections' => [[
                        'eyebrow' => 'Figure guerrière et prophétique',
                        'title' => 'La grande reine',
                        'description' => 'La figure de Morrigan est associée à Badb, Macha et Nemain, ainsi qu’à l’annonce de l’issue des combats.',
                    ]],
                    'editorialAttributes' => [
                        [
                            'name' => 'La forme aviaire',
                            'description' => 'Morrigan apparaît sous la forme d’une corneille ou d’un corbeau.',
                        ],
                        [
                            'name' => 'Le présage des combats',
                            'description' => 'Sa présence annonce l’issue des affrontements et la mort sur le champ de bataille.',
                        ],
                    ],
                    'genealogy' => [
                        [
                            'relation' => 'Époux / compagnon',
                            'name' => 'Dagda',
                            'detail' => 'Union rituelle à Samain',
                        ],
                    ],
                    'associations' => [
                        'Dagda' => 'Union rituelle à Samain',
                        'Badb' => 'Aspect associé de la Morrigan',
                        'Macha' => 'Figure associée à la triade',
                        'Nemain' => 'Aspect associé de la Morrigan',
                    ],
                ],
                'Atepomarus' => [
                    'chronicleParagraphs' => [
                        'Atepomarus, « le Grand Cavalier » ou « le Possesseur de grands chevaux », est un dieu équestre vénéré en Bourgogne et dans l’Indre.',
                        'Le cheval et la jument occupent une place centrale parmi ses attributs documentés. L’épée accompagne également son identité.',
                        'Le soleil lui est associé, sans constituer pour autant un domaine autonome.',
                        'Atepomarus était invoqué pour protéger les cavaliers et favoriser la fécondité des équidés.',
                        'Sa fonction témoigne de l’importance du cheval dans la culture gauloise. Les informations disponibles ne permettent toutefois pas de lui attribuer automatiquement la guerre, le voyage ou la souveraineté.',
                    ],
                    'chronicleHighlight' => 'Le Grand Cavalier protège ceux qui montent les chevaux et veille sur la fécondité des équidés.',
                    'thematicSections' => [[
                        'eyebrow' => 'Culte équestre gaulois',
                        'title' => 'Le Grand Cavalier',
                        'description' => 'Vénéré en Bourgogne et dans l’Indre, Atepomarus était invoqué pour la protection des cavaliers et la fécondité des équidés.',
                    ]],
                    'editorialAttributes' => [
                        [
                            'name' => 'Le cheval et la jument',
                            'description' => 'Les équidés sont au cœur de son identité et de sa fonction protectrice.',
                        ],
                        [
                            'name' => 'L’épée',
                            'description' => 'L’épée figure parmi les attributs documentés d’Atepomarus.',
                        ],
                        [
                            'name' => 'Le soleil',
                            'description' => 'Le soleil lui est associé, sans constituer un domaine autonome.',
                        ],
                    ],
                    'genealogy' => [],
                    'associations' => [],
                ],
                'Rhiannon' => [
                    'chronicleParagraphs' => [
                        'Rhiannon est une déesse équestre et souveraine liée à l’Autre Monde et à la musique enchanteresse. Elle apparaît sur une jument blanche que nul ne peut rattraper.',
                        'Ses oiseaux peuvent réveiller les morts, endormir les vivants et faire oublier les souffrances.',
                        'Son mariage avec Pwyll exprime la souveraineté féminine qui confère au roi son pouvoir légitime.',
                        'Faussement accusée d’avoir dévoré son fils Pryderi, elle endure avec dignité une longue humiliation avant que l’enfant soit retrouvé et lui soit rendu.',
                        'Après la mort de Pwyll, Rhiannon épouse Manawydan et affronte avec lui les sortilèges qui frappent leur royaume.',
                    ],
                    'chronicleHighlight' => 'Dame souveraine de l’Autre Monde, Rhiannon unit la jument blanche, la musique enchanteresse et la légitimité royale.',
                    'thematicSections' => [[
                        'eyebrow' => 'Souveraineté et Autre Monde',
                        'title' => 'La dame à la jument blanche',
                        'description' => 'La rencontre de Rhiannon avec Pwyll et leur mariage expriment une souveraineté féminine liée à la légitimité royale.',
                    ]],
                    'editorialAttributes' => [
                        [
                            'name' => 'La jument blanche',
                            'description' => 'Rhiannon apparaît sur une jument blanche que nul ne peut rattraper.',
                        ],
                        [
                            'name' => 'Les oiseaux enchanteurs',
                            'description' => 'Ses oiseaux réveillent les morts, endorment les vivants et font oublier les souffrances.',
                        ],
                    ],
                    'genealogy' => [
                        ['relation' => 'Premier époux', 'name' => 'Pwyll', 'detail' => null],
                        ['relation' => 'Fils', 'name' => 'Pryderi', 'detail' => null],
                        ['relation' => 'Second époux', 'name' => 'Manawydan', 'detail' => 'Après la mort de Pwyll'],
                    ],
                    'associations' => [
                        'Pwyll' => 'Époux et prince de Dyfed',
                        'Manawydan' => 'Second époux de Rhiannon',
                    ],
                ],
                'Arawn' => [
                    'chronicleParagraphs' => [
                        'Arawn règne sur Annwfn, l’Autre Monde gallois. Les récits le présentent comme un souverain noble et mystérieux.',
                        'Des chiens de chasse blancs aux oreilles rouges l’accompagnent. Le sanglier et le cor de chasse figurent également parmi ses attributs documentés.',
                        'Sa rencontre avec Pwyll ouvre une épreuve fondée sur l’échange d’apparence. Pendant un an, le prince prend les traits d’Arawn afin d’affronter Hafgan, son rival.',
                        'La réussite de cette épreuve établit entre Arawn et Pwyll un respect mutuel.',
                        'Les cochons d’Annwfn relèvent eux aussi de l’autorité d’Arawn. Un autre récit met en scène Gwydion, qui les dérobe afin de provoquer une guerre.',
                    ],
                    'chronicleHighlight' => 'Roi d’Annwfn, Arawn gouverne l’Autre Monde et soumet Pwyll à l’épreuve qui fonde leur respect mutuel.',
                    'thematicSections' => [[
                        'eyebrow' => 'Souveraineté de l’Autre Monde',
                        'title' => 'Le royaume d’Annwfn',
                        'description' => 'Arawn est le roi d’Annwfn et le souverain de l’Autre Monde gallois. Les récits placent sous son autorité ses chiens de chasse ainsi que les cochons d’Annwfn.',
                    ]],
                    'editorialAttributes' => [
                        [
                            'name' => 'Le cor de chasse',
                            'description' => 'Le cor de chasse figure parmi les attributs documentés du souverain d’Annwfn.',
                        ],
                        [
                            'name' => 'Les chiens d’Annwfn',
                            'description' => 'Des chiens de chasse blancs aux oreilles rouges accompagnent Arawn.',
                        ],
                        [
                            'name' => 'Le sanglier',
                            'description' => 'Le sanglier compte parmi les animaux et attributs associés à Arawn.',
                        ],
                    ],
                    'genealogy' => [],
                    'associations' => [
                        'Pwyll' => 'Échange d’apparence et épreuve contre Hafgan',
                        'Gwydion' => 'Vol des cochons d’Annwfn',
                    ],
                ],
                default => [
                    'chronicleParagraphs' => [],
                    'chronicleHighlight' => null,
                    'thematicSections' => [],
                    'editorialAttributes' => [],
                    'genealogy' => [],
                    'associations' => [],
                ],
            };
            $additionalGenealogy = match ($dieu->getName()) {
                'Danu' => [],
                'Lugh' => [
                    ['relation' => 'Père', 'name' => 'Cian', 'detail' => null],
                    ['relation' => 'Mère', 'name' => 'Ethniu', 'detail' => null],
                    ['relation' => 'Grand-père', 'name' => 'Balor', 'detail' => null],
                ],
                'Brigid' => [
                    ['relation' => 'Père', 'name' => 'Dagda', 'detail' => null],
                ],
                'Aengus Óg' => [
                    ['relation' => 'Père', 'name' => 'Dagda', 'detail' => null],
                    ['relation' => 'Mère', 'name' => 'Boann', 'detail' => null],
                    ['relation' => 'Père adoptif / éducateur', 'name' => 'Mider', 'detail' => 'Élevé auprès de Mider'],
                ],
                'Mider' => [
                    ['relation' => 'Épouse', 'name' => 'Étaín', 'detail' => null],
                    ['relation' => 'Épouse', 'name' => 'Fuamnach', 'detail' => 'Identifiée dans Tochmarc Étaíne'],
                    ['relation' => 'Fils adoptif', 'name' => 'Aengus Óg', 'detail' => 'Élevé auprès de Mider'],
                ],
                'Étaín' => [
                    ['relation' => 'Époux', 'name' => 'Mider', 'detail' => 'Relation liée au récit de sa transformation'],
                ],
                'Diancecht' => [
                    ['relation' => 'Fils', 'name' => 'Miach', 'detail' => null],
                    ['relation' => 'Fille', 'name' => 'Airmid', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Cian', 'detail' => null],
                ],
                'Airmid' => [
                    ['relation' => 'Père', 'name' => 'Diancecht', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Miach', 'detail' => null],
                ],
                'Cian' => [
                    ['relation' => 'Père', 'name' => 'Diancecht', 'detail' => null],
                    ['relation' => 'Partenaire / épouse dans le récit', 'name' => 'Ethniu', 'detail' => 'Fille de Balor et mère de Lugh'],
                    ['relation' => 'Fils', 'name' => 'Lugh', 'detail' => null],
                ],
                'Macha' => [
                    ['relation' => 'Époux dans le récit de la course', 'name' => 'Crunnchu', 'detail' => null],
                    ['relation' => 'Enfants', 'name' => 'Jumeaux non nommés', 'detail' => 'Le récit ne permet pas de créer des fiches individuelles'],
                ],
                'Manannán mac Lir' => [
                    ['relation' => 'Père', 'name' => 'Lir', 'detail' => null],
                ],
                'Boann' => [
                    ['relation' => 'Fils', 'name' => 'Aengus Óg', 'detail' => null],
                    ['relation' => 'Amant', 'name' => 'Dagda', 'detail' => 'Conception d’Aengus Óg'],
                    ['relation' => 'Époux selon une version', 'name' => 'Elcmar', 'detail' => 'Tochmarc Étaíne'],
                    ['relation' => 'Époux selon une autre tradition', 'name' => 'Nechtan', 'detail' => 'Variante documentaire'],
                ],
                'Balor' => [
                    ['relation' => 'Fille', 'name' => 'Ethniu', 'detail' => 'Aussi nommée Ethne dans certaines éditions'],
                    ['relation' => 'Gendre / alliance familiale', 'name' => 'Cian', 'detail' => 'Père de Lugh avec Ethniu'],
                    ['relation' => 'Petit-fils', 'name' => 'Lugh', 'detail' => 'Par sa fille Ethniu'],
                ],
                'Bres' => [
                    ['relation' => 'Père', 'name' => 'Elatha', 'detail' => 'Roi des Fomoires'],
                    ['relation' => 'Mère', 'name' => 'Ériu', 'detail' => 'Fille de Delbáeth dans Cath Maige Tuired'],
                ],
                'Ogme' => [['relation' => 'Frère', 'name' => 'Dagda', 'detail' => null]],
                'Sucellus' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Nantosuelta', 'detail' => null]],
                'Nantosuelta' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Sucellus', 'detail' => null]],
                'Belenus' => [['relation' => 'Association cultuelle', 'name' => 'Belisama', 'detail' => 'Présentée comme son épouse dans la tradition interne']],
                'Belisama' => [['relation' => 'Association cultuelle', 'name' => 'Belenus', 'detail' => 'Présenté comme son époux dans la tradition interne']],
                'Borvo' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Damona', 'detail' => null]],
                'Damona' => [
                    ['relation' => 'Parèdre / association cultuelle', 'name' => 'Borvo', 'detail' => null],
                    ['relation' => 'Parèdre / association cultuelle', 'name' => 'Moritasgus', 'detail' => null],
                ],
                'Moritasgus' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Damona', 'detail' => null]],
                'Bricta' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Luxovius', 'detail' => null]],
                'Luxovius' => [['relation' => 'Parèdre / association cultuelle', 'name' => 'Bricta', 'detail' => null]],
                'Ériu' => [
                    ['relation' => 'Sœur', 'name' => 'Banba', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Fódla', 'detail' => null],
                ],
                'Banba' => [
                    ['relation' => 'Sœur', 'name' => 'Ériu', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Fódla', 'detail' => null],
                ],
                'Fódla' => [
                    ['relation' => 'Sœur', 'name' => 'Ériu', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Banba', 'detail' => null],
                ],
                'Llew Llaw Gyffes' => [
                    ['relation' => 'Mère', 'name' => 'Arianrhod', 'detail' => null],
                    ['relation' => 'Épouse', 'name' => 'Blodeuwedd', 'detail' => 'Créée par Math et Gwydion'],
                    ['relation' => 'Oncle / protecteur', 'name' => 'Gwydion', 'detail' => null],
                ],
                'Arianrhod' => [
                    ['relation' => 'Mère', 'name' => 'Don', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Llew Llaw Gyffes', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Dylan Eil Ton', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Gwydion', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Gilfaethwy', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Amaethon', 'detail' => null],
                ],
                'Bran le Béni' => [
                    ['relation' => 'Père', 'name' => 'Llyr', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Branwen', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Manawydan', 'detail' => null],
                ],
                'Branwen' => [
                    ['relation' => 'Père', 'name' => 'Llyr', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Bran le Béni', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Manawydan', 'detail' => null],
                    ['relation' => 'Époux', 'name' => 'Matholwch', 'detail' => 'Roi d’Irlande'],
                    ['relation' => 'Fils', 'name' => 'Gwern', 'detail' => null],
                ],
                'Cerridwen' => [
                    ['relation' => 'Époux', 'name' => 'Tegid Foel', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Afagddu', 'detail' => null],
                    ['relation' => 'Fille', 'name' => 'Creirwy', 'detail' => null],
                ],
                'Don' => [
                    ['relation' => 'Fils', 'name' => 'Gwydion', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Gilfaethwy', 'detail' => null],
                    ['relation' => 'Fille', 'name' => 'Arianrhod', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Amaethon', 'detail' => null],
                ],
                'Lludd' => [
                    ['relation' => 'Frère', 'name' => 'Llevelys', 'detail' => null],
                ],
                'Dylan Eil Ton' => [
                    ['relation' => 'Mère', 'name' => 'Arianrhod', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Llew Llaw Gyffes', 'detail' => null],
                    ['relation' => 'Oncle / protecteur familial', 'name' => 'Gwydion', 'detail' => null],
                ],
                'Manawydan' => [
                    ['relation' => 'Père', 'name' => 'Llyr', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Bran le Béni', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Branwen', 'detail' => null],
                    ['relation' => 'Seconde épouse', 'name' => 'Rhiannon', 'detail' => null],
                    ['relation' => 'Beau-fils', 'name' => 'Pryderi', 'detail' => 'Fils de Rhiannon'],
                ],
                'Pwyll' => [
                    ['relation' => 'Épouse', 'name' => 'Rhiannon', 'detail' => null],
                    ['relation' => 'Fils', 'name' => 'Pryderi', 'detail' => null],
                ],
                'Blodeuwedd' => [['relation' => 'Époux', 'name' => 'Llew Llaw Gyffes', 'detail' => null]],
                'Gwydion' => [
                    ['relation' => 'Mère', 'name' => 'Don', 'detail' => null],
                    ['relation' => 'Sœur', 'name' => 'Arianrhod', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Gilfaethwy', 'detail' => null],
                    ['relation' => 'Frère', 'name' => 'Amaethon', 'detail' => null],
                    ['relation' => 'Neveu', 'name' => 'Llew Llaw Gyffes', 'detail' => 'Protégé et initié par Gwydion'],
                ],
                default => [],
            };

            $additionalAssociations = match ($dieu->getName()) {
                'Nuada' => ['Diancecht' => 'Guérison de son bras', 'Lugh' => 'Succession temporaire au trône'],
                'Diancecht' => ['Nuada' => 'Guérison de son bras d’argent'],
                'Airmid' => ['Diancecht' => 'Père et relation médicale', 'Nuada' => 'Cycle de la guérison des Tuatha Dé Danann'],
                'Goibniu' => ['Creidhne' => 'Collaboration artisanale', 'Luchtaine' => 'Collaboration artisanale'],
                'Creidhne' => ['Goibniu' => 'Collaboration artisanale', 'Luchtaine' => 'Collaboration artisanale'],
                'Luchtaine' => ['Goibniu' => 'Collaboration artisanale', 'Creidhne' => 'Collaboration artisanale'],
                'Badb' => ['Morrigan' => 'Figure associée', 'Macha' => 'Figure associée', 'Nemain' => 'Figure associée'],
                'Macha' => ['Morrigan' => 'Figure associée', 'Badb' => 'Figure associée', 'Nemain' => 'Figure associée'],
                'Nemain' => ['Morrigan' => 'Figure associée', 'Badb' => 'Figure associée', 'Macha' => 'Figure associée'],
                'Boann' => ['Dagda' => 'Parents d’Aengus Óg'],
                'Aengus Óg' => ['Boann' => 'Mère', 'Dagda' => 'Père'],
                'Bres' => ['Ériu' => 'Mère', 'Dagda' => 'Bâtisseur de sa forteresse et opposant à son règne', 'Ogme' => 'Soumis à son règne dans Cath Maige Tuired'],
                'Mider' => ['Aengus Óg' => 'Père adoptif / éducateur'],
                'Étaín' => ['Mider' => 'Époux', 'Aengus Óg' => 'Protecteur dans le récit', 'Manannán mac Lir' => 'Cycle narratif associé'],
                'Cerridwen' => ['Taliesin' => 'Métamorphoses, ingestion de Gwion Bach et renaissance'],
                'Taliesin' => ['Cerridwen' => 'Relation narrative de transformation et de renaissance'],
                'Pwyll' => ['Arawn' => 'Échange d’apparence et épreuve'],
                'Gwydion' => ['Math fab Mathonwy' => 'Récits communs', 'Llew Llaw Gyffes' => 'Protection et initiation', 'Blodeuwedd' => 'Participation à sa création', 'Arawn' => 'Vol des cochons d’Annwfn'],
                'Llew Llaw Gyffes' => ['Gwydion' => 'Protection et initiation', 'Math fab Mathonwy' => 'Création de Blodeuwedd'],
                'Blodeuwedd' => ['Gwydion' => 'Participation à sa création', 'Math fab Mathonwy' => 'Participation à sa création'],
                'Arawn' => ['Pwyll' => 'Échange d’apparence et épreuve', 'Gwydion' => 'Vol des cochons d’Annwfn'],
                default => [],
            };

            if ($editorialProfile['chronicleParagraphs'] === []) {
                $structuredChronicle = $editorialCatalog->chronicleFor($dieu->getName())
                    ?? $this->structureChronicle($dieu->getDescription());
                $editorialProfile['chronicleParagraphs'] = $structuredChronicle['paragraphs'];
                $editorialProfile['chronicleHighlight'] = $structuredChronicle['highlight'];
            }

            if ($editorialProfile['editorialAttributes'] === []) {
                $editorialProfile['editorialAttributes'] = $editorialCatalog->attributesFor($dieu);
            }

            if ($editorialProfile['thematicSections'] === []) {
                $editorialProfile['thematicSections'] = $editorialCatalog->thematicSectionsFor($dieu);
            }

            $excludedSymbols = match ($dieu->getName()) {
                'Ogmios' => ['Ogham'],
                'Epona' => ['Corne d’abondance'],
                'Rosmerta' => ['Torque'],
                default => [],
            };
            $displaySymbols = array_values(array_filter(
                $dieu->getSymboles()->toArray(),
                static fn ($symbol): bool => !in_array($symbol->getName(), $excludedSymbols, true),
            ));
            foreach ($editorialCatalog->symbolNamesFor($dieu->getName()) as $symbolName) {
                $symbol = $symboleRepository->findOneBy(['name' => $symbolName]);
                if ($symbol !== null && !array_any(
                    $displaySymbols,
                    static fn ($existingSymbol): bool => $existingSymbol->getId() === $symbol->getId(),
                )) {
                    $displaySymbols[] = $symbol;
                }
            }

            $excludedAnimals = match ($dieu->getName()) {
                'Belatucadros' => ['Sanglier'],
                'Epona' => ['Chien'],
                default => [],
            };
            $displayAnimals = array_values(array_filter(
                $dieu->getAnimaux()->toArray(),
                static fn ($animal): bool => !in_array($animal->getName(), $excludedAnimals, true),
            ));
            foreach ($editorialCatalog->animalNamesFor($dieu->getName()) as $animalName) {
                $animal = $animalRepository->findOneBy(['name' => $animalName]);
                if ($animal !== null && !array_any(
                    $displayAnimals,
                    static fn ($existingAnimal): bool => $existingAnimal->getId() === $animal->getId(),
                )) {
                    $displayAnimals[] = $animal;
                }
            }
            $animalContexts = [];
            foreach ($displayAnimals as $displayAnimal) {
                $animalContexts[$displayAnimal->getId()] = $editorialCatalog->animalContextFor(
                    $dieu->getName(),
                    $displayAnimal->getName(),
                );
            }

            if ($pantheon !== null) {
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

            foreach ($editorialProfile['associations'] as $name => $relation) {
                $associatedDieu = $dieuRepository->findOneBy(['name' => $name]);

                if ($associatedDieu instanceof Dieu) {
                    $associatedDeities[] = [
                        'dieu' => $associatedDieu,
                        'relation' => $relation,
                    ];
                }
            }

            foreach ($additionalAssociations as $name => $relation) {
                $associatedDieu = $dieuRepository->findOneBy(['name' => $name]);
                if ($associatedDieu instanceof Dieu && !array_any(
                    $associatedDeities,
                    static fn (array $association): bool => $association['dieu']->getId() === $associatedDieu->getId(),
                )) {
                    $associatedDeities[] = ['dieu' => $associatedDieu, 'relation' => $relation];
                }
            }

            foreach ([...$editorialProfile['genealogy'], ...$additionalGenealogy] as $genealogyEntry) {
                $genealogyDieu = $dieuRepository->findOneBy(['name' => $genealogyEntry['name']]);
                $genealogy[] = [
                    ...$genealogyEntry,
                    'dieu' => $genealogyDieu,
                ];

                if ($genealogyDieu instanceof Dieu) {
                    $alreadyAssociated = array_any(
                        $associatedDeities,
                        static fn (array $association): bool => $association['dieu']->getId() === $genealogyDieu->getId(),
                    );

                    if (!$alreadyAssociated) {
                        $associatedDeities[] = [
                            'dieu' => $genealogyDieu,
                            'relation' => $genealogyEntry['relation'],
                        ];
                    }
                }
            }

            $unifiedContext = [
                'associatedDeities' => $associatedDeities,
                'chronicleParagraphs' => $editorialProfile['chronicleParagraphs'],
                'chronicleHighlight' => $editorialProfile['chronicleHighlight'],
                'editorialAttributes' => $editorialProfile['editorialAttributes'],
                'displayAnimals' => $displayAnimals,
                'animalContexts' => $animalContexts,
                'displaySymbols' => $displaySymbols,
                'genealogy' => $genealogy,
                'nextDieu' => $nextDieu,
                'pantheonTitle' => $pantheon?->getTitle(),
                'publicDescription' => $editorialCatalog->publicDescriptionFor($dieu),
                'thematicSections' => $editorialProfile['thematicSections'],
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

    /**
     * @return array{paragraphs: list<string>, highlight: ?string}
     */
    private function structureChronicle(?string $description): array
    {
        if ($description === null || trim($description) === '') {
            return ['paragraphs' => [], 'highlight' => null];
        }

        $sentences = preg_split(
            '/(?<=[.!?])\s+(?=[\p{Lu}À-ÖØ-Þ«])/u',
            trim(preg_replace('/\s+/u', ' ', $description) ?? $description),
            -1,
            PREG_SPLIT_NO_EMPTY,
        );

        if ($sentences === false || count($sentences) < 2) {
            return ['paragraphs' => [trim($description)], 'highlight' => null];
        }

        $highlightIndex = intdiv(count($sentences), 2);
        $highlight = $sentences[$highlightIndex];
        unset($sentences[$highlightIndex]);

        $paragraphs = [];
        foreach (array_chunk(array_values($sentences), 2) as $sentenceGroup) {
            $paragraphs[] = implode(' ', $sentenceGroup);
        }

        return [
            'paragraphs' => $paragraphs,
            'highlight' => $highlight,
        ];
    }
}
