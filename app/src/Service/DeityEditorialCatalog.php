<?php

namespace App\Service;

use App\Entity\Dieu;

final class DeityEditorialCatalog
{
    /**
     * @return array{paragraphs: list<string>, highlight: ?string}|null
     */
    public function chronicleFor(string $deityName): ?array
    {
        return match ($deityName) {
            'Airmid' => [
                'paragraphs' => [
                    'Airmid est une figure irlandaise de la guérison et de la connaissance des plantes médicinales. Elle appartient à la famille du dieu médecin Diancecht et son récit est étroitement lié à celui de son frère Miach.',
                    'Après la mort de Miach, les herbes médicinales poussent sur sa tombe. Airmid les recueille et les classe sur son manteau selon leurs propriétés, préservant ainsi un savoir thérapeutique ordonné.',
                    'Diancecht disperse toutefois les plantes, empêchant que leur classement complet soit transmis. Cet épisode fait d’Airmid la gardienne d’une connaissance médicale à la fois précieuse et perdue.',
                ],
                'highlight' => 'Gardienne des herbes médicinales, Airmid incarne un savoir thérapeutique recueilli puis dispersé.',
            ],
            'Banba' => [
                'paragraphs' => [
                    'Banba est l’une des trois déesses souveraines et éponymes de l’Irlande avec Ériu et Fódla. Toutes trois personnifient le lien entre la terre insulaire et la légitimité de ceux qui prétendent la gouverner.',
                    'Lors de l’arrivée des Milesiens, chacune demande que son nom soit donné au pays. Le nom d’Ériu devient le nom principal de l’île, tandis que Banba et Fódla demeurent des appellations poétiques de l’Irlande.',
                    'La documentation conservée ne lui attribue ni animal personnel ni généalogie développée au-delà de cette fratrie souveraine.',
                ],
                'highlight' => 'Avec Ériu et Fódla, Banba exprime la souveraineté de la terre d’Irlande.',
            ],
            'Fódla' => [
                'paragraphs' => [
                    'Fódla forme avec Ériu et Banba la triade des déesses souveraines et éponymes de l’Irlande. Leur récit associe le nom du territoire à la reconnaissance de sa puissance féminine.',
                    'À l’arrivée des Milesiens, Fódla demande que l’île porte son nom. Ériu obtient le nom principal, mais Fódla reste, comme Banba, une désignation poétique traditionnelle du pays.',
                    'Les documents disponibles développent surtout cette fonction territoriale et la relation de sœur à sœur ; ils ne justifient pas de lui attribuer artificiellement d’autres symboles ou animaux.',
                ],
                'highlight' => 'Fódla conserve dans la poésie l’un des noms souverains de l’Irlande.',
            ],
            'Bres' => [
                'paragraphs' => [
                    'Bres est un roi des Tuatha Dé Danann réputé pour sa beauté. Son accession au pouvoir intervient lorsque Nuada ne peut plus exercer la royauté après la perte de son bras.',
                    'Son règne devient cependant un temps de contrainte et de tribut au profit des Fomoires. Le défaut de générosité et de justice royale qui lui est reproché conduit à sa déchéance.',
                    'Après la bataille de Mag Tuired, la tradition lui attribue la transmission de connaissances agricoles. Cette conclusion rattache à l’agriculture une figure dont le récit demeure d’abord celui d’une souveraineté défaillante.',
                ],
                'highlight' => 'La beauté de Bres ne suffit pas à légitimer une royauté privée de justice et de générosité.',
            ],
            'Creidhne' => [
                'paragraphs' => [
                    'Creidhne est l’artisan divin spécialisé dans le travail du bronze. Son domaine complète ceux de Goibniu, maître de la forge, et de Luchtaine, artisan du bois.',
                    'Dans la préparation de la bataille de Mag Tuired, les trois artisans coopèrent à la fabrication et à la réparation de l’équipement des Tuatha Dé Danann. Leur efficacité repose sur la complémentarité de leurs métiers.',
                    'Les sources disponibles documentent cette collaboration artisanale, mais ne permettent pas d’en faire une relation familiale.',
                ],
                'highlight' => 'Avec Goibniu et Luchtaine, Creidhne fait de la maîtrise artisanale une force collective.',
            ],
            'Luchtaine' => [
                'paragraphs' => [
                    'Luchtaine est l’artisan divin du bois et de la charpente. Sa spécialité le distingue de Creidhne, associé au bronze, et de Goibniu, maître du travail forgé.',
                    'Le récit de la bataille de Mag Tuired réunit ces artisans dans la préparation des armes et de leur équipement. Luchtaine fournit les éléments de bois nécessaires à l’œuvre commune.',
                    'Cette triade est une collaboration fonctionnelle documentée ; aucune parenté ne doit en être déduite.',
                ],
                'highlight' => 'Luchtaine complète le bronze de Creidhne et la forge de Goibniu par la maîtrise du bois.',
            ],
            'Mider' => [
                'paragraphs' => [
                    'Mider est un souverain de l’Autre Monde associé au domaine de Brí Léith. Le Dagda lui confie Aengus Óg, qu’il élève pendant neuf années.',
                    'Dans Tochmarc Étaíne, Aengus obtient pour lui la main d’Étaín. Mider ramène alors Étaín dans son domaine, où vit déjà Fuamnach, explicitement présentée comme son épouse.',
                    'La jalousie de Fuamnach provoque les métamorphoses et l’exil d’Étaín. Après sa renaissance, Mider la reconnaît et cherche à la ramener auprès de lui.',
                    'La relation entre Mider et Étaín traverse ainsi plusieurs existences, tandis que sa relation avec Aengus relève de l’éducation et de la parenté adoptive.',
                ],
                'highlight' => 'Souverain de Brí Léith, Mider relie le récit d’Étaín à l’éducation du jeune Aengus.',
            ],
            'Boann' => [
                'paragraphs' => [
                    'Boann personnifie la Boyne et les eaux liées à la sagesse. Son identité divine demeure inséparable de la rivière qui porte son nom.',
                    'Tochmarc Étaíne la nomme aussi Eithne et la présente comme l’épouse d’Elcmar. Le Dagda s’unit à elle pendant l’absence d’Elcmar ; de cette relation naît Aengus Óg.',
                    'Une autre tradition rattache Boann à Nechtan. Ces versions sont conservées comme variantes documentaires et ne doivent pas être fondues en un statut conjugal unique.',
                ],
                'highlight' => 'Déesse de la Boyne et mère d’Aengus, Boann appartient à des traditions conjugales divergentes.',
            ],
            'Belisama' => [
                'paragraphs' => [
                    'Belisama, « la très brillante », est une déesse gauloise associée aux lacs, aux rivières, au feu, aux arts et à la lumière.',
                    'Elle est rapprochée de Belenus dans la documentation interne. Faute de preuve suffisante d’un statut matrimonial uniforme, leur lien est présenté prudemment comme une association cultuelle.',
                    'Une inscription la rapproche également de Minerve sous le nom de Minerve Belisama. Cette assimilation romaine éclaire certaines fonctions sans effacer son identité gauloise.',
                ],
                'highlight' => 'Belisama unit l’éclat de la lumière aux puissances de l’eau et du feu.',
            ],
            default => null,
        };
    }

    public function publicDescriptionFor(Dieu $dieu): string
    {
        return match ($dieu->getName()) {
            'Belisama' => 'Belisama, « la très brillante », est une déesse gauloise associée aux lacs, aux rivières, au feu, aux arts et à la lumière. Elle est liée à Belenus par une association cultuelle documentée, sans qu’un statut matrimonial universel soit affirmé.',
            default => (string) $dieu->getDescription(),
        };
    }

    /**
     * Editorial facts transcribed from Divinites_Celtiques.docx and
     * Divinites_Celtiques_Complet.pdf. They enrich the public rendering only.
     *
     * @var array<string, array{role: string, attributes: list<string>}>
     */
    private const DOCUMENTED_FACTS = [
        'Cernunnos' => ['role' => 'Dieu des animaux, de la fertilité et du monde souterrain', 'attributes' => ['Bois de cerf', 'Torque', 'Serpent à tête de bélier']],
        'Taranis' => ['role' => 'Dieu du tonnerre et du ciel', 'attributes' => ['Roue à six rayons', 'Foudre', 'Marteau']],
        'Toutatis' => ['role' => 'Dieu protecteur de la tribu', 'attributes' => ['Bouclier', 'Épée', 'Casque']],
        'Esus' => ['role' => 'Dieu bûcheron, lié à la végétation et au sacrifice', 'attributes' => ['Hache', 'Arbre', 'Taureau']],
        'Sucellus' => ['role' => 'Dieu de l’agriculture, du vin et de la forgerie', 'attributes' => ['Maillet', 'Tonneau', 'Chien']],
        'Belenus' => ['role' => 'Dieu guérisseur et dieu de la lumière', 'attributes' => ['Soleil', 'Cheval', 'Roue']],
        'Borvo' => ['role' => 'Dieu des sources thermales et de la guérison', 'attributes' => ['Source chaude', 'Marteau', 'Pain']],
        'Ogmios' => ['role' => 'Dieu de l’éloquence et de l’érudition', 'attributes' => ['Chaînes de l’éloquence', 'Massue']],
        'Maponos' => ['role' => 'Dieu de la jeunesse et de la poésie', 'attributes' => ['Lyre', 'Arc', 'Sanglier']],
        'Nodens' => ['role' => 'Dieu des guérisons, de la mer, de la chasse et des chiens', 'attributes' => ['Chien', 'Main', 'Poissons', 'Roue']],
        'Ambisagrus' => ['role' => 'Dieu du ciel et des phénomènes atmosphériques', 'attributes' => ['Foudre', 'Épée']],
        'Apollo Grannus' => ['role' => 'Dieu de la guérison et des sources thermales', 'attributes' => ['Source', 'Soleil', 'Rayon lumineux']],
        'Cissonius' => ['role' => 'Dieu des échanges et du commerce', 'attributes' => ['Caducée', 'Bourse']],
        'Condatis' => ['role' => 'Dieu des confluences et des rivières', 'attributes' => ['Eau', 'Confluent', 'Deux rivières se rejoignant']],
        'Dis Pater' => ['role' => 'Dieu souterrain, dieu des morts et ancêtre des Gaulois', 'attributes' => ['Souterrain', 'Nuit', 'Pâture sombre']],
        'Gobannus' => ['role' => 'Dieu forgeron', 'attributes' => ['Marteau', 'Enclume', 'Feu']],
        'Smertrios' => ['role' => 'Dieu de la guerre', 'attributes' => ['Massue', 'Serpent', 'Lion']],
        'Moccus' => ['role' => 'Protecteur des sangliers et des cochons', 'attributes' => ['Sanglier']],
        'Mullo' => ['role' => 'Dieu guérisseur associé à Apollon', 'attributes' => ['Cheval', 'Roue', 'Soleil']],
        'Nemausus' => ['role' => 'Dieu protecteur de Nîmes et de sa source sacrée', 'attributes' => ['Source', 'Serpent', 'Soleil']],
        'Atepomarus' => ['role' => 'Dieu équestre', 'attributes' => ['Cheval', 'Jument', 'Épée']],
        'Belatucadros' => ['role' => 'Dieu de la guerre', 'attributes' => ['Épée', 'Bouclier']],
        'Ialonus' => ['role' => 'Dieu des prairies et des clairières', 'attributes' => ['Prairie', 'Arbre', 'Clairière']],
        'Abellio' => ['role' => 'Dieu lié aux pommiers', 'attributes' => ['Pommier', 'Pomme']],
        'Artio' => ['role' => 'Déesse des ours', 'attributes' => ['Ourse', 'Corbeille de fruits']],
        'Arduinna' => ['role' => 'Déesse de la forêt d’Ardenne', 'attributes' => ['Sanglier', 'Arc', 'Forêt']],
        'Epona' => ['role' => 'Déesse de la fertilité et protectrice des chevaux', 'attributes' => ['Jument', 'Poulain', 'Clef', 'Manteau']],
        'Belisama' => ['role' => 'Déesse des eaux, du feu, des arts et de la lumière', 'attributes' => ['Feu', 'Lac', 'Lumière', 'Torche']],
        'Rosmerta' => ['role' => 'Déesse de la fertilité et de l’abondance', 'attributes' => ['Corne d’abondance', 'Caducée', 'Tonneau']],
        'Nantosuelta' => ['role' => 'Déesse de la nature, de la terre, du feu et de la fertilité', 'attributes' => ['Maison sur perche', 'Râteau', 'Abeille', 'Tonneau']],
        'Sequana' => ['role' => 'Déesse de la Seine et de la guérison', 'attributes' => ['Barque', 'Source', 'Canard']],
        'Sulis' => ['role' => 'Déesse des sources thermales et du soleil', 'attributes' => ['Eau chaude', 'Soleil', 'Roue']],
        'Damona' => ['role' => 'Déesse de la guérison et de la fertilité', 'attributes' => ['Vache', 'Serpent', 'Source']],
        'Andraste' => ['role' => 'Déesse de la victoire', 'attributes' => ['Lièvre', 'Armes', 'Feu']],
        'Andarta' => ['role' => 'Déesse guerrière liée à l’ours', 'attributes' => ['Ours', 'Armes']],
        'Cathubodua' => ['role' => 'Déesse guerrière et prophétique', 'attributes' => ['Corbeau', 'Épée', 'Sang']],
        'Bricta' => ['role' => 'Déesse des eaux et de la guérison', 'attributes' => ['Eau', 'Source', 'Lumière']],
        'Erecura' => ['role' => 'Déesse de la terre et du monde souterrain', 'attributes' => ['Corbeille de fruits', 'Serpent', 'Terre']],
        'Cailleach' => ['role' => 'Figure de l’hiver, des montagnes et des paysages', 'attributes' => ['Bâton', 'Pierre', 'Montagne', 'Hiver']],
        'Suleviae' => ['role' => 'Déesses protectrices et nourricières', 'attributes' => ['Corbeille', 'Nourrice', 'Enfant']],
        'Dea Matrona' => ['role' => 'Déesse de la rivière Marne', 'attributes' => ['Rivière', 'Enfant', 'Panier']],
        'Adsullata' => ['role' => 'Déesse liée à l’eau et au soleil', 'attributes' => ['Eau', 'Soleil', 'Rivière']],
        'Arubianus' => ['role' => 'Dieu agraire', 'attributes' => ['Champ', 'Charrue']],
        'Latobius' => ['role' => 'Dieu des montagnes', 'attributes' => ['Montagne', 'Ours']],
        'Nehalennia' => ['role' => 'Déesse protectrice des voyageurs maritimes', 'attributes' => ['Mer', 'Navire', 'Corne d’abondance']],
        'Dagda' => ['role' => 'Dieu-père des Tuatha Dé Danann', 'attributes' => ['Chaudron d’abondance', 'Lorg Mór', 'Harpe du temps']],
        'Lugh' => ['role' => 'Dieu de la maîtrise de tous les arts', 'attributes' => ['Lance', 'Corbeau', 'Sanglier', 'Lyre']],
        'Nuada' => ['role' => 'Roi des Tuatha Dé Danann', 'attributes' => ['Bras d’argent', 'Épée invincible', 'Main']],
        'Ogme' => ['role' => 'Dieu de l’éloquence et de l’écriture', 'attributes' => ['Chaînes', 'Ogham', 'Massue']],
        'Aengus Óg' => ['role' => 'Dieu de l’amour et de la jeunesse', 'attributes' => ['Cygne', 'Harpe', 'Baiser transformant']],
        'Mider' => ['role' => 'Souverain de l’Autre Monde', 'attributes' => ['Rose', 'Épée', 'Trois grues']],
        'Manannán mac Lir' => ['role' => 'Dieu de la mer et gardien de l’Autre Monde', 'attributes' => ['Bateau magique', 'Manteau d’invisibilité', 'Cochon']],
        'Goibniu' => ['role' => 'Dieu forgeron des Tuatha Dé Danann', 'attributes' => ['Marteau', 'Enclume', 'Bière d’immortalité']],
        'Diancecht' => ['role' => 'Dieu médecin des Tuatha Dé Danann', 'attributes' => ['Herbes', 'Eau', 'Bandages']],
        'Balor' => ['role' => 'Chef des Fomoires au regard destructeur', 'attributes' => ['Œil maléfique', 'Poison', 'Foudre']],
        'Cian' => ['role' => 'Père de Lugh et maître de la métamorphose', 'attributes' => ['Cochon', 'Métamorphose']],
        'Morrigan' => ['role' => 'Déesse de la guerre, du destin et de la prophétie', 'attributes' => ['Corbeau', 'Loup', 'Sang', 'Rivière']],
        'Brigid' => ['role' => 'Déesse du feu, de la poésie et de la guérison', 'attributes' => ['Feu', 'Eau', 'Lait', 'Croix de Brigid']],
        'Macha' => ['role' => 'Déesse de la souveraineté et de la guerre', 'attributes' => ['Jument', 'Couronne', 'Épée']],
        'Áine' => ['role' => 'Déesse solaire liée à la souveraineté', 'attributes' => ['Soleil', 'Cheval rouge', 'Lièvre']],
        'Danu' => ['role' => 'Déesse mère des Tuatha Dé Danann', 'attributes' => ['Terre', 'Rivière', 'Nourriture']],
        'Badb' => ['role' => 'Déesse guerrière et prophétique', 'attributes' => ['Corbeau', 'Sang', 'Lave']],
        'Nemain' => ['role' => 'Déesse de la frénésie guerrière', 'attributes' => ['Cri perçant', 'Corneille', 'Tempête']],
        'Boann' => ['role' => 'Déesse de la Boyne et des eaux de la sagesse', 'attributes' => ['Rivière', 'Source', 'Saumon de la sagesse']],
        'Ériu' => ['role' => 'Déesse souveraine de l’Irlande', 'attributes' => ['Couronne', 'Terre', 'Sceptre']],
        'Math fab Mathonwy' => ['role' => 'Roi-magicien du Gwynedd', 'attributes' => ['Bâton magique', 'Trône', 'Pieds']],
        'Gwydion' => ['role' => 'Magicien et maître des transformations', 'attributes' => ['Bâton', 'Incantation', 'Transformation']],
        'Llew Llaw Gyffes' => ['role' => 'Héros solaire à la main habile', 'attributes' => ['Lance', 'Aigle', 'Soleil']],
        'Arawn' => ['role' => 'Roi d’Annwfn', 'attributes' => ['Chiens blancs aux oreilles rouges', 'Sanglier', 'Cor de chasse']],
        'Pwyll' => ['role' => 'Prince de Dyfed lié à l’Autre Monde', 'attributes' => ['Chiens de chasse', 'Montagne']],
        'Rhiannon' => ['role' => 'Souveraine équestre liée à l’Autre Monde', 'attributes' => ['Jument blanche', 'Oiseaux', 'Sac magique']],
        'Bran le Béni' => ['role' => 'Roi géant et protecteur de l’île de Bretagne', 'attributes' => ['Tête coupée', 'Corbeau', 'Pont de bateaux']],
        'Branwen' => ['role' => 'Princesse liée à la paix entre les royaumes', 'attributes' => ['Étoile', 'Mer', 'Oiseau']],
        'Cerridwen' => ['role' => 'Gardienne du chaudron de l’inspiration', 'attributes' => ['Chaudron de l’inspiration', 'Grain', 'Sanglier']],
        'Taliesin' => ['role' => 'Barde inspiré et détenteur de la connaissance', 'attributes' => ['Chaudron', 'Lyre', 'Front lumineux']],
        'Arianrhod' => ['role' => 'Déesse de la roue d’argent et des étoiles', 'attributes' => ['Couronne circulaire', 'Roue d’argent', 'Étoiles']],
        'Don' => ['role' => 'Déesse mère de la lignée de Dôn', 'attributes' => ['Terre', 'Foyer', 'Étoile']],
        'Blodeuwedd' => ['role' => 'Femme créée à partir de fleurs', 'attributes' => ['Fleurs de chêne', 'Genêt', 'Reine-des-prés', 'Hibou']],
        'Lludd' => ['role' => 'Roi protecteur de l’île de Bretagne', 'attributes' => ['Main d’argent', 'Filet', 'Épée']],
    ];

    /** @var array<string, list<string>> */
    private const DOCUMENTED_SYMBOLS = [
        'Cernunnos' => ['Torque'], 'Taranis' => ['Roue solaire'], 'Toutatis' => ['Bouclier'],
        'Esus' => ['Hache d’Esus'], 'Sucellus' => ['Maillet de Sucellus'], 'Belenus' => ['Roue solaire'],
        'Ogmios' => ['Chaînes de l’éloquence'], 'Belatucadros' => ['Bouclier'], 'Rosmerta' => ['Corne d’abondance'],
        'Lugh' => ['Lance de Lugh'], 'Nuada' => ['Bras d’argent', 'Épée de Nuada'],
        'Ogme' => ['Chaînes de l’éloquence', 'Ogham'],
        'Manannán mac Lir' => ['Bateau magique', 'Manteau de brume'],
        'Math fab Mathonwy' => ['Baguette magique'], 'Gwydion' => ['Baguette magique'],
        'Arianrhod' => ['Roue d’argent'], 'Blodeuwedd' => ['Fleurs de Blodeuwedd'],
        'Bran le Béni' => ['Tête coupée'], 'Cerridwen' => ['Chaudron d’inspiration'],
        'Nehalennia' => ['Corne d’abondance'],
    ];

    /** @var array<string, list<string>> */
    private const DOCUMENTED_ANIMALS = [
        'Cernunnos' => ['Serpent à tête de bélier'], 'Sucellus' => ['Chien'], 'Belenus' => ['Cheval'],
        'Maponos' => ['Sanglier'], 'Nodens' => ['Chien'], 'Moccus' => ['Sanglier'], 'Mullo' => ['Cheval'],
        'Atepomarus' => ['Cheval'], 'Artio' => ['Ours'], 'Arduinna' => ['Sanglier'], 'Epona' => ['Cheval'],
        'Andarta' => ['Ours'], 'Cathubodua' => ['Corbeau'], 'Latobius' => ['Ours'],
        'Lugh' => ['Corbeau', 'Sanglier'], 'Aengus Óg' => ['Cygne'], 'Mider' => ['Grue'],
        'Manannán mac Lir' => ['Cochon'], 'Cian' => ['Cochon'], 'Morrigan' => ['Corbeau', 'Loup'],
        'Macha' => ['Cheval'], 'Áine' => ['Cheval'], 'Badb' => ['Corbeau'], 'Nemain' => ['Corbeau'],
        'Boann' => ['Saumon'], 'Rhiannon' => ['Cheval'], 'Bran le Béni' => ['Corbeau'],
        'Cerridwen' => ['Sanglier'], 'Arawn' => ['Chien', 'Sanglier', 'Cochon'], 'Pwyll' => ['Chien'],
    ];

    /** @return list<array{name: string, description: string}> */
    public function attributesFor(Dieu $dieu): array
    {
        $facts = self::DOCUMENTED_FACTS[$dieu->getName()] ?? null;
        if ($facts === null) {
            return [];
        }

        $animalTerms = [
            'Abeille', 'Aigle', 'Canard', 'Cheval', 'Cheval rouge', 'Chien', 'Chiens blancs aux oreilles rouges',
            'Chiens de chasse', 'Cochon', 'Corbeau', 'Corneille', 'Hibou', 'Jument', 'Jument blanche', 'Lièvre',
            'Lion', 'Oiseau', 'Oiseaux', 'Ourse', 'Ours', 'Poissons', 'Poulain', 'Sanglier', 'Saumon de la sagesse',
            'Serpent', 'Serpent à tête de bélier', 'Taureau', 'Trois grues', 'Vache',
        ];
        $weapons = ['Arc', 'Armes', 'Bouclier', 'Casque', 'Cor de chasse', 'Épée', 'Épée invincible', 'Filet', 'Foudre', 'Hache', 'Lance', 'Lorg Mór', 'Marteau', 'Massue'];
        $naturalElements = ['Arbre', 'Bois de cerf', 'Champ', 'Clairière', 'Confluent', 'Deux rivières se rejoignant', 'Eau', 'Eau chaude', 'Feu', 'Forêt', 'Hiver', 'Lac', 'Lave', 'Lumière', 'Mer', 'Montagne', 'Nuit', 'Pâture sombre', 'Pierre', 'Prairie', 'Rayon lumineux', 'Rivière', 'Soleil', 'Source', 'Source chaude', 'Souterrain', 'Tempête', 'Terre'];
        $motifs = ['Baiser transformant', 'Cri perçant', 'Enfant', 'Incantation', 'Métamorphose', 'Nourrice', 'Nourriture', 'Pieds', 'Poison', 'Sang', 'Transformation'];

        $attributes = [];
        foreach ($facts['attributes'] as $attribute) {
            if (in_array($attribute, $animalTerms, true)) {
                continue;
            }

            $category = match (true) {
                in_array($attribute, $weapons, true) => 'Arme ou objet de pouvoir',
                in_array($attribute, $naturalElements, true) => 'Élément naturel ou lieu cultuel',
                in_array($attribute, $motifs, true) => 'Pouvoir ou motif narratif',
                default => 'Objet ou attribut représenté',
            };
            $attributes[] = [
                'name' => sprintf('%s — %s', $category, $attribute),
                'description' => sprintf('%s est documenté dans la présentation de %s, %s.', $attribute, $dieu->getName(), mb_strtolower($facts['role'])),
            ];
        }

        return $attributes;
    }

    /** @return list<array{eyebrow: string, title: string, description: string}> */
    public function thematicSectionsFor(Dieu $dieu): array
    {
        $facts = self::DOCUMENTED_FACTS[$dieu->getName()] ?? null;
        $description = trim((string) $dieu->getDescription());
        if ($facts === null || substr_count($description, '.') < 2) {
            return [];
        }

        $sentences = preg_split('/(?<=[.!?])\s+(?=[\p{Lu}À-ÖØ-Þ«])/u', $description, 3, PREG_SPLIT_NO_EMPTY);

        return [[
            'eyebrow' => $facts['role'],
            'title' => $dieu->getTitle() ?: $dieu->getName(),
            'description' => implode(' ', array_slice($sentences ?: [$description], 0, 2)),
        ]];
    }

    /** @return list<string> */
    public function symbolNamesFor(string $deityName): array
    {
        return self::DOCUMENTED_SYMBOLS[$deityName] ?? [];
    }

    /** @return list<string> */
    public function animalNamesFor(string $deityName): array
    {
        return self::DOCUMENTED_ANIMALS[$deityName] ?? [];
    }

    public function animalContextFor(string $deityName, string $animalName): string
    {
        return match (true) {
            $deityName === 'Cian' && $animalName === 'Cochon' => 'Métamorphose attestée',
            $deityName === 'Aengus Óg' && $animalName === 'Cygne' => 'Métamorphose et motif narratif',
            $deityName === 'Étaín' && in_array($animalName, ['Mouche', 'Papillon'], true) => 'Métamorphose narrative',
            $deityName === 'Étaín' && $animalName === 'Cygne' => 'Métamorphose dans le récit de Mider',
            $deityName === 'Macha' && $animalName === 'Cheval' => 'Course et association équestre',
            $deityName === 'Arduinna' && $animalName === 'Sanglier' => 'Monture iconographique',
            $deityName === 'Artio' && $animalName === 'Ours' => 'Animal iconographique et cultuel',
            $deityName === 'Arawn' && $animalName === 'Chien' => 'Compagnon de chasse',
            $deityName === 'Arawn' && in_array($animalName, ['Sanglier', 'Cochon'], true) => 'Animal lié aux récits d’Annwfn',
            $deityName === 'Pwyll' && $animalName === 'Chien' => 'Compagnon de chasse narratif',
            in_array($deityName, ['Morrigan', 'Badb', 'Nemain'], true) && $animalName === 'Corbeau' => 'Forme ou présage guerrier',
            default => 'Animal associé',
        };
    }
}
