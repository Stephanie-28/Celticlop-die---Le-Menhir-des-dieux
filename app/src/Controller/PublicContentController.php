<?php

namespace App\Controller;

use App\Entity\Chronique;
use App\Entity\Savoir;
use App\Entity\User;
use App\Enum\SavoirEditorialType;
use App\Repository\ChroniqueRepository;
use App\Repository\AnimalRepository;
use App\Repository\SavoirRepository;
use App\Repository\SymboleRepository;
use App\Service\FavoriteCatalog;
use App\Service\ArchiveCatalog;
use App\Service\SavoirDossierPresenter;
use App\Service\MythStoryCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PublicContentController extends AbstractController
{
    #[Route('/archives-du-druide', name: 'app_public_savoir_index', methods: ['GET'])]
    public function savoirIndex(SavoirRepository $repository): Response
    {
        $dossierOrder = ['Parchemins Anciens', 'Alphabet Ogham', "Secrets d'Avalon", 'Prophéties', 'Sagesse Druidique'];
        $dossiersByTitle = [];
        foreach ($repository->findByEditorialType(SavoirEditorialType::DOSSIER) as $dossier) {
            $dossiersByTitle[$dossier->getTitle()] = $dossier;
        }

        return $this->render('public/content/savoirs.html.twig', [
            'dossiers' => array_values(array_filter(array_map(
                static fn (string $title): ?Savoir => $dossiersByTitle[$title] ?? null,
                $dossierOrder,
            ))),
            'focus' => $repository->findFocus(),
        ]);
    }

    #[Route('/archives-du-druide/bibliotheque', name: 'app_public_savoir_library', methods: ['GET'])]
    public function savoirLibrary(SavoirRepository $repository, ArchiveCatalog $archiveCatalog): Response
    {
        $officialSavoirs = $repository->findByEditorialType(SavoirEditorialType::OFFICIEL);
        $discoveries = $repository->findByEditorialType(SavoirEditorialType::DECOUVERTE);
        $dossiersByTitle = [];
        foreach ($repository->findByEditorialType(SavoirEditorialType::DOSSIER) as $dossier) {
            $dossiersByTitle[$dossier->getTitle()] = $dossier;
        }
        $dossiers = array_values(array_filter(array_map(
            static fn (string $title): ?Savoir => $dossiersByTitle[$title] ?? null,
            ['Parchemins Anciens', 'Alphabet Ogham', "Secrets d'Avalon", 'Prophéties', 'Sagesse Druidique'],
        )));

        return $this->render('public/content/savoir_library.html.twig', [
            'officialSavoirs' => $officialSavoirs,
            'discoveries' => $discoveries,
            'dossiers' => $dossiers,
            'catalog' => $archiveCatalog->build($officialSavoirs, $discoveries, $dossiers),
        ]);
    }

    #[Route('/archives-du-druide/{id}', name: 'app_public_savoir_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function savoirShow(Savoir $savoir, SavoirDossierPresenter $dossierPresenter): Response
    {
        return $this->render('public/content/savoir_show.html.twig', [
            'savoir' => $savoir,
            'dossierPresentation' => $dossierPresenter->present($savoir),
        ]);
    }

    #[Route('/chroniques-mythiques', name: 'app_public_chronique_index', methods: ['GET'])]
    public function chroniqueIndex(ChroniqueRepository $repository, MythStoryCatalog $storyCatalog): Response
    {
        return $this->render('public/content/chroniques.html.twig', [
            'chroniques' => $repository->findBy([], ['publishedAt' => 'DESC']),
            'featuredStories' => $storyCatalog->all(),
        ]);
    }

    #[Route('/chroniques-mythiques/{slug}', name: 'app_public_story_show', requirements: ['slug' => '[a-z][a-z0-9-]*'], methods: ['GET'])]
    public function storyShow(string $slug, MythStoryCatalog $storyCatalog): Response
    {
        $story = $storyCatalog->find($slug);
        if ($story !== null) {
            return $this->render('public/content/story_show.html.twig', ['story' => $story]);
        }

        throw $this->createNotFoundException('Ce récit mythologique est introuvable.');
    }

    /**
     * @return list<array{slug: string, title: string, eyebrow: string, summary: string, content: list<string>, image: string, imageAlt: string}>
     */
    private function featuredStories(): array
    {
        return [
                [
                    'slug' => 'cycle-ulster',
                    'title' => "Le Cycle d’Ulster",
                    'eyebrow' => 'Irlande héroïque',
                    'summary' => "Plongez dans les récits légendaires de Cúchulainn, héros d’Ulster, au cœur de la Táin Bó Cúailnge.",
                    'content' => [
                        "Dans la Táin Bó Cúailnge (Razzia des vaches de Cooley), Morrigan tente de séduire le héros Cúchulainn, qui la repousse. Elle prend alors la forme d’une anguille, d’une louve et d’une génisse pour l’attaquer pendant son combat contre le guerrier Loegaire.",
                        "Blessée par Cúchulainn, elle réapparaît sous les traits d’une vieille femme trayant une vache. Le héros, sans la reconnaître, la guérit en buvant le lait. Ainsi, elle obtient la guérison qu’elle cherchait.",
                        "À la mort de Cúchulainn, Morrigan se pose sous forme de corneille sur son épaule, signe que le héros est condamné. Dans la Bataille de Mag Tuired, elle chante un poème prophétique annonçant la victoire des Tuatha Dé Danann sur les Fomoires.",
                    ],
                    'image' => 'images/mythes/cycle-ulster.png',
                    'imageAlt' => "Pierres celtiques au bord d’un lac d’Ulster à l’aube",
                ],
                [
                    'slug' => 'branche-rouge',
                    'title' => 'Le Cycle de la Branche Rouge',
                    'eyebrow' => 'Serments et batailles',
                    'summary' => "Suivez les exploits guerriers de Conchobar et Cúchulainn dans les histoires de la cour d’Emain Macha.",
                    'content' => [
                        "À Emain Macha, la cour du roi Conchobar rassemble les guerriers de la Branche Rouge. Cúchulainn en devient la figure centrale : champion précoce, gardien des frontières de l’Ulster et combattant solitaire durant la grande razzia de Cooley.",
                        "Le jeune héros doit son nom au chien du forgeron Culann. Après avoir tué l’animal qui gardait la demeure, il promet d’en assurer lui-même la fonction jusqu’à ce qu’un nouveau chien soit dressé. Il devient ainsi Cú Chulainn, le chien de Culann.",
                        "Ses combats, ses serments et sa destinée tragique incarnent l’idéal héroïque de l’Ulster : une bravoure sans mesure, liée à la fidélité au clan et à l’acceptation d’une gloire aussi éclatante que brève.",
                    ],
                    'image' => 'images/mythes/branche-rouge.png',
                    'imageAlt' => 'Bouclier celtique en bronze parmi les bruyères',
                ],
                [
                    'slug' => 'voyage-bran',
                    'title' => "Le Voyage de Bran",
                    'eyebrow' => 'Voyage vers l’Autre Monde',
                    'summary' => "Un voyage mystique au-delà de l’horizon, guidé par Manannán vers les îles bienheureuses.",
                    'content' => [
                        "Dans le Voyage de Bran, Manannán apparaît à Bran sur l’océan et l’invite à visiter l’Autre Monde. Il lui révèle que la mer qu’il voit n’est qu’une plaine fleurie dans l’autre royaume, et que les poissons y sont des veaux et des agneaux.",
                        "Le dieu de la mer règne sur les brumes, la navigation et les passages invisibles. Il guide les voyageurs vers Emain Ablach, l’île des pommes, demeure bienheureuse où le temps humain perd son emprise.",
                        "Ce voyage rappelle que, dans les récits celtiques, l’Autre Monde ne se trouve pas seulement après la mort : il demeure tout près du monde visible, séparé de lui par une étendue d’eau, un brouillard ou un instant d’enchantement.",
                    ],
                    'image' => 'images/mythes/voyage-bran.png',
                    'imageAlt' => "Navire celtique approchant une île de l’Autre Monde",
                ],
                [
                    'slug' => 'cernunnos-chaudron-gundestrup', 'title' => 'Cernunnos et le chaudron de Gundestrup', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Le dieu cornu règne au centre du monde animal et des forces de régénération.',
                    'content' => ["Le chaudron de Gundestrup présente la représentation la plus élaborée de Cernunnos. Le dieu cornu y siège au centre d’une scène, entourant de ses bras un cerf et un serpent à tête de bélier, symboles de sa maîtrise du monde animal.", "Les autres panneaux montrent sacrifices, processions et guerriers. Ils suggèrent que Cernunnos occupait une place centrale dans les rites de fertilité et de régénération. Sur le Pilier des Nautes, il apparaît aux côtés de Jupiter et Vulcain ; sa posture assise évoque la méditation et la maîtrise des énergies telluriques."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'taranis-roue-solaire', 'title' => 'Taranis et la roue solaire', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Du dieu terrible décrit par Lucain au gardien de l’ordre cosmique.',
                    'content' => ["Lucain décrit Taranis comme un dieu terrible exigeant des sacrifices par le feu. Les découvertes archéologiques nuancent cependant cette image : ses monuments révèlent plutôt un dieu de l’ordre cosmique, garant du cycle des saisons et de la régularité des phénomènes célestes.", "La roue solaire qui l’accompagne est un symbole de chance et de prospérité bien plus qu’un instrument de mort. Plusieurs sanctuaires lui étaient dédiés en Gaule et dans les régions germaniques."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'esus-tarvos-trigaranus', 'title' => 'Esus et Tarvos Trigaranus', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Le taureau aux trois grues traverse un mystérieux cycle de métamorphoses.',
                    'content' => ["Le mythe d’Esus est intimement lié à Tarvos Trigaranus, le taureau aux trois grues. Sa version complète nous échappe, mais semble décrire un cycle de métamorphoses dans lequel le taureau, les grues et l’arbre représentent des êtres ou des forces en transformation perpétuelle.", "L’acte d’Esus abattant l’arbre provoque la métamorphose du taureau en grues, symbolisant le passage d’un état à un autre. Les Romains comparaient Esus à Mars ou à Mercure selon les traditions."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'toutatis-eaux-primordiales', 'title' => 'Toutatis et les eaux primordiales', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Le sacrifice dans les eaux sacrées devient un passage vers la régénération.',
                    'content' => ["Selon les sources romaines, les sacrifices offerts à Toutatis consistaient en noyades dans un chaudron ou un lac sacré. Le prisonnier de guerre était plongé tête la première dans un récipient rempli de liquide, symbolisant le retour aux eaux primordiales et la régénération par le sacrifice.", "Cette pratique rappelle le motif du chaudron magique, omniprésent dans la mythologie celtique, où il devient un instrument de résurrection et d’abondance."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'sucellus-nantosuelta', 'title' => 'Sucellus et Nantosuelta', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Le couple divin unit la fécondité de la terre à la prospérité du foyer.',
                    'content' => ["Sucellus est souvent représenté aux côtés de Nantosuelta. Ensemble, ils forment un couple divin symbolisant la fécondité de la terre et la prospérité du foyer.", "Dans les représentations gallo-romaines, Sucellus est parfois associé à Silvanus ou Vulcain. Son maillet relie le travail artisanal à la création divine, tandis que les légendes d’Alsace et de Bourgogne ont conservé son souvenir dans les forêts et les eaux souterraines."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'belenus-feux-beltaine', 'title' => 'Belenus et les feux de Beltaine', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Les feux du printemps célèbrent la victoire de la lumière sur les ténèbres.',
                    'content' => ["La fête de Beltaine, célébrée le premier mai, est traditionnellement associée à Belenus. Les Celtes allumaient de grands feux de joie pour purifier le bétail et les habitations avant la saison estivale.", "Le feu symbolise la victoire de la lumière sur les ténèbres, de l’été sur l’hiver et de la vie sur la mort. Hérodien raconte qu’au siège d’Aquilée, une apparition divine attribuée à Belenus poussa les soldats romains à lever le siège."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'ogmios-chaines-eloquence', 'title' => 'Ogmios et les chaînes de l’éloquence', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'La parole du vieux dieu se révèle plus puissante que la force physique.',
                    'content' => ["Lucien rapporte qu’un diplomate gaulois lui expliqua que les Gaulois considéraient l’éloquence comme la plus grande des forces. Le vieillard Ogmios représente une parole dont la puissance ne diminue jamais avec l’âge.", "Il est probablement l’équivalent gaulois d’Ogme, dieu irlandais de l’éloquence et inventeur de l’écriture oghamique, surnommé « à la langue de miel »."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'epona-cheval-autre-monde', 'title' => 'Epona et le cheval de l’Autre Monde', 'eyebrow' => 'Tradition gauloise',
                    'summary' => 'Rhiannon et Macha prolongent les récits équestres de la déesse cavale.',
                    'content' => ["Epona est associée à la déesse galloise Rhiannon et à l’Irlandaise Macha. Dans le Mabinogi, Rhiannon apparaît sur un cheval blanc que nul ne peut rattraper, même lorsqu’il avance au pas.", "Macha, déesse-cheval, court plus vite que les chevaux du roi mais meurt en accouchant après avoir été forcée de courir. Ces récits montrent le pouvoir ambivalent du cheval, à la fois monture divine et créature de mort."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon gaulois',
                ],
                [
                    'slug' => 'andraste-revolte-boadicee', 'title' => 'Andraste et la révolte de Boadicée', 'eyebrow' => 'Tradition brittonique',
                    'summary' => 'Un lièvre libéré avant la bataille devient le présage de la victoire.',
                    'content' => ["Avant sa révolte contre l’occupation romaine, Boadicée invoqua Andraste. Dion Cassius rapporte qu’elle libéra un lièvre caché dans son manteau afin de lire dans sa course un présage de victoire.", "Le lièvre, messager de l’Autre Monde, était associé à la déesse invincible. Son culte accompagnait vraisemblablement les rites guerriers de la reine et de son peuple."],
                    'image' => 'images/placeholders/pantheon-gaulois.png', 'imageAlt' => 'Illustration du panthéon brittonique',
                ],
                [
                    'slug' => 'dagda-bataille-mag-tuired', 'title' => 'Le Dagda à Mag Tuired', 'eyebrow' => 'Tradition irlandaise',
                    'summary' => 'Le dieu bon prépare la victoire des Tuatha Dé Danann contre les Fomoires.',
                    'content' => ["Dans la Cath Maige Tuired, le Dagda joue un rôle central dans la guerre entre les Tuatha Dé Danann et les Fomoires. Son union rituelle avec Morrigan au moment de Samain assure la victoire de son peuple.", "Son chaudron, l’un des quatre trésors apportés des villes mythiques du Nord, garantit la prospérité. Dans un récit humoristique, il dévore l’immense repas préparé par les Fomoires pour le ridiculiser, puis séduit la fille de l’ennemi."],
                    'image' => 'images/dieux/dagda-portrait.png', 'imageAlt' => 'Portrait du Dagda',
                ],
                [
                    'slug' => 'brigit-flamme-kildare', 'title' => 'Brigit et la flamme de Kildare', 'eyebrow' => 'Tradition irlandaise',
                    'summary' => 'La triple déesse transmet son feu sacré jusque dans la tradition chrétienne.',
                    'content' => ["Brigit, fille du Dagda, possède deux bœufs sacrés, Fe et Men, ainsi qu’un verrat nommé Triath. Ses trois domaines correspondent à la poésie, à la guérison et à la forge.", "Après la christianisation, elle devient sainte Brigitte de Kildare. La flamme perpétuelle entretenue par les religieuses prolonge la tradition du feu sacré de l’ancienne déesse."],
                    'image' => 'images/placeholders/pantheon-irlandais.png', 'imageAlt' => 'Illustration du panthéon irlandais',
                ],
                [
                    'slug' => 'lugh-bataille-balor', 'title' => 'Lugh face à Balor', 'eyebrow' => 'Tradition irlandaise',
                    'summary' => 'Le maître de tous les arts conduit les Tuatha Dé Danann à la victoire.',
                    'content' => ["Arrivé à Tara, Lugh se voit refuser l’entrée parce qu’il ne possède pas un art unique. Il demande alors si un homme maîtrise tous les arts ensemble ; comme nul ne peut le prétendre, il est admis.", "Lors de la seconde Bataille de Mag Tuired, il tue son grand-père Balor, roi des Fomoires, d’une pierre de fronde dans son œil mortel. La fête de Lughnasa célèbre encore son nom au début des récoltes."],
                    'image' => 'images/placeholders/pantheon-irlandais.png', 'imageAlt' => 'Illustration du panthéon irlandais',
                ],
                [
                    'slug' => 'nuada-bras-argent', 'title' => 'Nuada au bras d’argent', 'eyebrow' => 'Tradition irlandaise',
                    'summary' => 'Un roi mutilé retrouve son intégrité et son trône grâce aux dieux médecins.',
                    'content' => ["Nuada perd son bras droit lors de la première Bataille de Mag Tuired contre les Fir Bolg. La loi interdisant à un roi imparfait de régner, il doit abandonner son trône.", "Diancecht lui fabrique un bras d’argent parfaitement fonctionnel, puis Miach fait renaître son bras de chair et d’os par ses incantations. Nuada peut alors reprendre sa souveraineté avant de céder la conduite de la guerre à Lugh."],
                    'image' => 'images/placeholders/pantheon-irlandais.png', 'imageAlt' => 'Illustration du panthéon irlandais',
                ],
                [
                    'slug' => 'aengus-reve-amour', 'title' => 'Le rêve d’amour d’Aengus', 'eyebrow' => 'Tradition irlandaise',
                    'summary' => 'Le dieu amoureux devient cygne pour rejoindre la jeune femme apparue en rêve.',
                    'content' => ["Aengus voit en rêve une jeune fille d’une beauté incomparable et tombe malade d’amour. Aidé par Boann et le Dagda, il la cherche pendant trois ans avant de la retrouver au lac de la Bouche du Dragon, sous la forme d’un cygne.", "La jeune fille est la fille d’un roi de l’Autre Monde et subit une métamorphose cyclique. Aengus devient lui-même cygne pour la rejoindre ; leur chant endort de bonheur tous ceux qui l’entendent pendant trois jours et trois nuits."],
                    'image' => 'images/placeholders/pantheon-irlandais.png', 'imageAlt' => 'Illustration du panthéon irlandais',
                ],
                [
                    'slug' => 'rhiannon-pryderi', 'title' => 'Rhiannon et le retour de Pryderi', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'Accusée à tort, la reine endure l’épreuve avant de restaurer l’ordre.',
                    'content' => ["Après son mariage avec Pwyll, Rhiannon est faussement accusée d’avoir dévoré son nouveau-né Pryderi, enlevé durant la nuit. Condamnée à rester sept ans à la porte du palais, elle doit proposer de porter les visiteurs sur son dos.", "Elle supporte l’humiliation avec dignité jusqu’au retour de l’enfant. Après la mort de Pwyll, elle épouse Manawydan et affronte avec lui les sortilèges qui transforment le royaume en désert."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
                [
                    'slug' => 'math-creation-blodeuwedd', 'title' => 'Math et la création de Blodeuwedd', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'Le roi-magicien façonne une femme avec les fleurs du chêne, de l’aubépine et du genêt.',
                    'content' => ["Dans le quatrième rameau du Mabinogi, Math fab Mathonwy règne sur le Gwynedd et maîtrise la magie des transformations.", "Avec Gwydion, il crée Blodeuwedd à partir des fleurs du chêne, de l’aubépine et du genêt afin de donner une épouse à Llew Llaw Gyffes, que sa mère Arianrhod avait condamné à ne jamais épouser une femme humaine."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
                [
                    'slug' => 'arianrhod-interdits-llew', 'title' => 'Arianrhod et les interdits de Llew', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'La déesse refuse à son fils un nom, des armes et une épouse.',
                    'content' => ["Arianrhod refuse de donner un nom, des armes et une épouse à son fils Llew Llaw Gyffes. Sans nom, un homme ne possède aucune existence sociale ; la déesse exerce ainsi sur lui un pouvoir de destin.", "Gwydion déjoue chaque interdit par la ruse et la magie. Il permet à Llew d’obtenir son identité et ses armes, puis participe avec Math à la création de Blodeuwedd."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
                [
                    'slug' => 'blodeuwedd-femme-fleur', 'title' => 'Blodeuwedd, la femme-fleur', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'Créée par magie, elle trahit Llew avant d’être changée en hibou.',
                    'content' => ["Créée avec des fleurs pour devenir l’épouse de Llew, Blodeuwedd tombe amoureuse du chasseur Gronw Pebyr. Elle découvre les conditions impossibles nécessaires pour tuer son mari et prépare sa mort.", "Frappé, Llew se transforme en aigle mais Gwydion le guérit. Pour punir Blodeuwedd, le magicien la change en hibou, oiseau nocturne rejeté par les autres oiseaux."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
                [
                    'slug' => 'ceridwen-naissance-taliesin', 'title' => 'Ceridwen et la naissance de Taliesin', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'Une poursuite de métamorphoses donne naissance au plus grand des bardes.',
                    'content' => ["Furieuse que Gwion ait volé la science de son chaudron, Ceridwen le poursuit. Il devient lièvre et elle levrette ; il devient poisson et elle loutre ; il devient oiseau et elle faucon ; enfin, il se change en grain de blé et elle l’avale sous la forme d’une poule noire.", "Neuf mois plus tard, elle enfante un garçon d’une beauté éclatante. Incapable de le tuer, elle l’abandonne sur la mer dans une corbeille. Recueilli par le prince Elffin, l’enfant devient Taliesin, le plus grand poète de la tradition galloise."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
                [
                    'slug' => 'bran-tete-protectrice', 'title' => 'Bran et la tête protectrice', 'eyebrow' => 'Tradition galloise',
                    'summary' => 'La tête du géant continue de protéger la Bretagne après sa mort.',
                    'content' => ["Mortellement blessé par une lance empoisonnée lors de la guerre d’Irlande, Bran ordonne aux survivants de lui couper la tête et de l’emporter à Londres. Enterrée sous la Tour Blanche face à la France, elle doit protéger l’île de toute invasion.", "Le roi Arthur retire ensuite la tête de Bran, préférant défendre la Bretagne par sa propre force plutôt que par la magie. Depuis lors, l’île est vulnérable : le récit marque le passage de l’ère mythique à l’ère historique."],
                    'image' => 'images/placeholders/pantheon-gallois.png', 'imageAlt' => 'Illustration du panthéon gallois',
                ],
        ];
    }

    #[Route('/chroniques-mythiques/{id}', name: 'app_public_chronique_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function chroniqueShow(Chronique $chronique): Response
    {
        return $this->render('public/content/chronique_show.html.twig', ['chronique' => $chronique]);
    }

    #[Route('/reliques', name: 'app_public_relique_index', methods: ['GET'])]
    public function reliques(SymboleRepository $symboleRepository, AnimalRepository $animalRepository): Response
    {
        return $this->render('public/content/reliques.html.twig', [
            'symboles' => $symboleRepository->findBy([], ['name' => 'ASC']),
            'animaux' => $animalRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/mon-sanctuaire', name: 'app_public_sanctuary', methods: ['GET'])]
    public function sanctuary(FavoriteCatalog $favoriteCatalog): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('public/content/sanctuary.html.twig', [
            'favoriteGroups' => $favoriteCatalog->forUser($user),
        ]);
    }
}
