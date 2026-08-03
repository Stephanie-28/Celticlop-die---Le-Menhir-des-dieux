Le Menhir des Dieux - Celticlopédie
CAHIER DES CHARGES — Encyclopédie Celtique Interactive

1. SYNOPSIS ET VISION
   ● Contexte et Concept

Le projet vise à concevoir une application web interactive dédiée à la mythologie celtique.
L’utilisateur pourra y parcourir une base de données de divinités celtiques, explorer leurs symboles, découvrir les animaux qui leur sont associés (bestiaire) ainsi que les récits mythologiques qui les entourent et plus.
Une dimension ludique viendra enrichir l’expérience grâce à un quiz permettant de déterminer son ou c'est « dieu protecteur ».

● Objectifs et Enjeux

Objectifs :

- Concevoir une application web complète (front + back)
- Manipuler une base de données relationnelle
- Créer une interface utilisateur moderne et intuitive
- Structurer un projet selon des bonnes pratiques

Enjeux :

- Gestion de données complexes (relations multiples)
- Respect des délais
- Maintenir un équilibre entre richesse et simplicité

2. GLOSSAIRE
   Dieu : Entité principale de la base de données
   Panthéon : Origine culturelle (Gaulois, Irlandais, Gallois)
   Symbole : Élément associé à un dieu (triskèle, roue…)
   Bestiaire : Animaux liés aux divinités (corbeau, cerf…)
   Mythe : Récit lié à un dieu
   Quiz : Fonction interactive attribuant un dieu à l’utilisateur
   Playlist : Musique associée à chaque dieu
   Favoris : Liste personnalisée de dieux sauvegardés par un utilisateur
   CRUD : Création, lecture, modification et suppression de contenu
   Chronique : Récit développé racontant un mythe.
   Savoir préservé : Article documentaire consultable.
   Chaque mois, un savoir est mis en avant dans le Focus du mois.
   Focus du mois : Mise en avant d'un savoir préservé sur la page Archives du Druide.
   Profil de l'Initié : Progression de l'utilisateur basée sur le nombre de favoris enregistrés.
   Réponse : Choix proposé dans une question du quiz attribuant des points à un dieu.

3. SPÉCIFICATIONS FONCTIONNELLES (PAR EPICS)
   EPIC 1 : Navigation et découverte des divinités

- Accéder à une page d’accueil
- Naviguer vers les différentes sections
- Voir la liste des dieux
- Filtrer par panthéon
- Rechercher un dieu
- Recherche alphabétique
- Recherche par symbole
- Voir les dieux liés à un panthéon
- Consulter les Chroniques Mythologiques
- Consulter les Savoirs Préservés
- Consulter le Focus du mois
- Consulter les Cycles Mythologiques
- Consulter les mythes par catégorie (Dieux & Nature, Héros, Rois)
- Accéder aux mythes par catégorie

EPIC 2 : Consultation des fiches détaillées

- Voir une fiche détaillée d’un dieu
- Afficher description, image
- Voir symboles associés
- Voir animaux (bestiaire)
- Lire les mythes liés
- Voir les animaux associés à un dieu
- Voir les symboles associés à un dieu
- Voir les caractéristiques communes avec d’autres dieux
- Voir une phrase d'accroche associée à chaque dieu
- Consulter les mythes associés à un dieu
- Voir la musique associée au dieu
- Voir le panthéon du dieu
- Voir la chronique racontant le mythe

EPIC 3 : Exploration des symboles et du bestiaire

- Accéder à une page dédiée
- Voir liste des symboles et animaux
- Filtrer par type (animal / symbole)
- Consulter description

EPIC 4 : Interaction utilisateur (Quiz)

- Répondre à un quiz
- Associer le résultat à un dieu
- Refaire le quiz à volonté
- Obtenir son dieu protecteur
- Choisir d'ajouter ou non le dieu obtenu dans ses favoris

EPIC 5 : Expérience immersive (Playlist)

- Voir liste des dieux avec musique
- Voir la liste des musiques associées aux dieux
- Écouter une musique depuis les favoris.
- Écouter une musique liée à un dieu
- Accéder à la bibliothèque musicale
- Écouter la musique d'un dieu présent dans ses favoris

EPIC 6 : Gestion utilisateur

- Créer un compte
- Se connecter
- Accéder à son profil
- Gérer son profil
- Voir l’historique des quiz
- Accéder aux musiques associées aux divinités favorites.
- Consulter sa liste de dieux favoris
- Modifier son mot de passe
- Se déconnecter
- Consulter son Profil de l'Initié
- Voir son titre actuel
- Voir son titre précédent
- Consulter tous ses favoris
- Ajouter un favori
- Retirer un favori

EPIC 7 : Administration du contenu

- Gérer les dieux (CRUD)
- Gérer les symboles (CRUD)
- Gérer les animaux (CRUD)
- Gérer les mythes (CRUD)
- Gérer les musiques (CRUD)
- Gérer les panthéons (CRUD)
- Gérer les questions du quiz (CRUD)
- Gérer les réponses du quiz (CRUD)
- Gérer les Chroniques (CRUD)
- Gérer les Savoirs Préservés (CRUD)

EPIC 8 : Archives du Druide

- Consulter les Chroniques Mythologiques
- Consulter les Savoirs Préservés
- Consulter le Focus du mois
- Parcourir les Cycles Mythologiques
- Accéder aux mythes classés par catégories
- Lire une chronique
- Lire un savoir préservé

Product Backlog — Le Menhir des Dieux : Celticlopédie
Les acteurs :
🍃 Voyageur (Visiteur)
Découvre librement l'univers de Celticlopédie sans créer de compte.
🌿 Initié (Utilisateur)
Possède un compte et accède aux fonctionnalités personnalisées.
🌳 Grand Druide (Administrateur)
Gère l'ensemble du contenu de Celticlopédie.

EPIC 1 — Navigation et découverte des divinités
Objectif :
Permettre au Voyageur de découvrir l'univers de Celticlopédie grâce aux différentes fonctionnalités de navigation et de recherche.
US01 — Découvrir Celticlopédie
En tant que 🍃 Voyageur (Visiteur)
Je souhaite accéder à la page d'accueil
Afin de découvrir l'univers de Celticlopédie.
Priorité : Haute
Critères d'acceptation
La page d'accueil est accessible sans connexion.
Les principales rubriques sont visibles.
Les liens de navigation fonctionnent.
Le site est responsive.

US02 — Naviguer dans les différentes sections
En tant que 🍃 Voyageur (Visiteur)
Je souhaite naviguer entre les différentes rubriques
Afin de découvrir les contenus proposés.
Priorité : Haute
Critères d'acceptation
Le menu principal est visible.
Toutes les rubriques sont accessibles.
La navigation est intuitive.
La rubrique active est identifiable.

US03 — Consulter la liste des dieux
En tant que 🍃 Voyageur (Visiteur)
Je souhaite consulter la liste des divinités
Afin de découvrir les dieux celtiques.
Priorité : Haute
Critères d'acceptation
Tous les dieux sont affichés.
Chaque dieu possède un nom.
Chaque dieu possède une illustration.
Un clic permet d'accéder à sa fiche.

US04 — Rechercher un dieu
En tant que 🍃 Voyageur (Visiteur)
Je souhaite rechercher une divinité
Afin de la retrouver rapidement.
Priorité : Haute
Critères d'acceptation
Une barre de recherche est disponible.
La recherche s'effectue par nom.
Les résultats sont affichés correctement.

US05 — Filtrer les dieux par panthéon
En tant que 🍃 Voyageur (Visiteur)
Je souhaite filtrer les dieux selon leur panthéon
Afin de découvrir une tradition celtique particulière.
Priorité : Moyenne
Critères d'acceptation
Tous les panthéons sont proposés.
Le filtre fonctionne correctement.
Les dieux affichés correspondent au panthéon sélectionné.

US06 — Rechercher un dieu par ordre alphabétique
En tant que 🍃 Voyageur (Visiteur)
Je souhaite rechercher un dieu en saisissant les premières lettres de son nom
Afin de retrouver rapidement la divinité recherchée.
Priorité : Basse
Critères d'acceptation
Une barre de recherche est disponible.
La recherche fonctionne dès les premières lettres saisies.
Les résultats correspondent au texte recherché.
Les dieux sont filtrés automatiquement.

US07 — Rechercher les dieux associés à un symbole
En tant que 🍃 Voyageur (Visiteur)
Je souhaite rechercher les dieux liés à un symbole
Afin de comprendre leur symbolique.
Priorité : Moyenne
Critères d'acceptation
Les symboles disponibles sont proposés.
Les dieux associés sont affichés.
Les résultats correspondent au symbole sélectionné.

US08 — Découvrir les différents panthéons
En tant que 🍃 Voyageur (Visiteur)
Je souhaite consulter les panthéons
Afin de mieux comprendre l'origine des divinités.
Priorité : Basse
Critères d'acceptation
Les panthéons sont accessibles.
Leur description est affichée.
Les dieux appartenant à chaque panthéon sont consultables.

EPIC 2 — Consultation des fiches des divinités
Objectif :
Permettre au Voyageur de découvrir une divinité et à l'Initié d'accéder à l'ensemble des informations disponibles.

US09 — Consulter la fiche d'un dieu
En tant que 🍃 Voyageur (Visiteur)
Je souhaite consulter la fiche d'une divinité
Afin de découvrir ses principales informations.
Priorité : Haute
Critères d'acceptation
La fiche est accessible depuis la liste des dieux.
Le nom du dieu est affiché.
Une illustration est visible.
Une description est disponible.

US10 — Consulter la fiche complète d'un dieu
En tant que 🌿 Initié (Utilisateur)
Je souhaite accéder à la fiche complète d'un dieu
Afin de consulter toutes les informations disponibles.
Priorité : Haute
Critères d'acceptation
Toutes les informations du dieu sont affichées.
Les symboles associés sont visibles.
Les animaux associés sont visibles.
Les panthéons sont affichés.
Les mythes associés sont consultables.
Les caractéristiques communes avec d'autres dieux sont affichées.
La phrase d'accroche est visible.
US11 — Consulter les mythes associés à un dieu
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter les mythes associés à une divinité
Afin de approfondir mes connaissances sur son histoire.
Priorité : Moyenne
Critères d'acceptation
Les mythes associés au dieu sont affichés.
Chaque mythe est consultable.
Les informations sont accessibles uniquement après connexion.
La navigation vers les mythes fonctionne correctement.

US12 — Découvrir les dieux ayant des caractéristiques communes
En tant que 🍃 Voyageur (Visiteur)
Je souhaite découvrir des dieux similaires
Afin de poursuivre ma découverte de la mythologie celtique.
Priorité : Basse
Critères d'acceptation
Les dieux similaires sont proposés.
Chaque dieu est accessible.
Les liens fonctionnent correctement.

US13 — Ajouter un dieu à mes favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite enregistrer un dieu dans mes favoris
Afin de le retrouver facilement.
Priorité : Haute
Critères d'acceptation
Un bouton "Ajouter aux favoris" est disponible.
Le dieu est enregistré.
Une confirmation est affichée.

EPIC 3 — Exploration des symboles et du bestiaire
Objectif :
Permettre au Voyageur de découvrir les symboles et les animaux emblématiques de la mythologie celtique ainsi que leurs liens avec les divinités.

US14 — Accéder à la page des symboles et du bestiaire
En tant que 🍃 Voyageur (Visiteur)
Je souhaite accéder à la page des symboles et du bestiaire
Afin de découvrir ces éléments de la mythologie celtique.
Priorité : Moyenne
Critères d'acceptation
La page est accessible depuis le menu.
Les symboles et les animaux sont visibles.
La navigation est fluide.

US15 — Consulter un symbole
En tant que 🍃 Voyageur (Visiteur)
Je souhaite consulter un symbole
Afin de comprendre sa signification.
Priorité : Moyenne
Critères d'acceptation
Le symbole possède un nom.
Une illustration est affichée.
Une description est disponible.
Les dieux associés sont visibles.

US16 — Consulter un animal du bestiaire
En tant que 🍃 Voyageur (Visiteur)
Je souhaite consulter un animal
Afin de découvrir sa place dans la mythologie.
Priorité : Moyenne
Critères d'acceptation
L'animal possède un nom.
Une illustration est affichée.
Une description est disponible.
Les dieux associés sont visibles.

US17 — Filtrer les contenus
En tant que 🍃 Voyageur (Visiteur)
Je souhaite filtrer les contenus
Afin de afficher uniquement les symboles ou uniquement les animaux.
Priorité : Basse
Critères d'acceptation
Un filtre est disponible.
Le filtre « Symboles » fonctionne.
Le filtre « Animaux » fonctionne.
Les résultats sont mis à jour automatiquement.

US18 — Ajouter un symbole ou un animal à mes favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite enregistrer un symbole ou un animal
Afin de les retrouver facilement.
Priorité : Moyenne
Critères d'acceptation
Le bouton Favori est disponible.
L'ajout est enregistré.
Une confirmation est affichée.

EPIC 4 — Interaction utilisateur (Quiz)
Objectif :
Permettre à l'Initié de découvrir son dieu protecteur grâce à un quiz interactif.

US19 — Accéder au quiz
En tant que 🌿 Initié (Utilisateur)
Je souhaite accéder au quiz
Afin de découvrir mon dieu protecteur.
Priorité : Haute
Critères d'acceptation
Le quiz est accessible après connexion.
Le bouton de lancement est visible.
Les questions s'affichent correctement.

US20 — Répondre aux questions
En tant que 🌿 Initié (Utilisateur)
Je souhaite répondre aux questions du quiz
Afin de obtenir un résultat personnalisé.
Priorité : Haute
Critères d'acceptation
Toutes les questions sont affichées.
Une réponse peut être sélectionnée par question.
Il est possible de passer à la question suivante.

US21 — Obtenir mon dieu protecteur
En tant que 🌿 Initié (Utilisateur)
Je souhaite obtenir le résultat du quiz
Afin de découvrir mon dieu protecteur.
Priorité : Haute
Critères d'acceptation
Le dieu ayant obtenu le plus de points est affiché.
Son nom est visible.
Son image est affichée.
Un accès à sa fiche est proposé.

US22 — Ajouter le dieu obtenu à mes favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite choisir d'ajouter mon dieu protecteur à mes favoris
Afin de le retrouver ultérieurement.
Priorité : Moyenne
Critères d'acceptation
Une proposition d'ajout est affichée après le résultat.
L'utilisateur peut accepter ou refuser.
Si accepté, le dieu est ajouté aux favoris.

US23 — Refaire le quiz
En tant que 🌿 Initié (Utilisateur)
Je souhaite refaire le quiz
Afin de découvrir un autre dieu protecteur.
Priorité : Moyenne
Critères d'acceptation
Le quiz peut être relancé sans limite.
Les anciennes tentatives restent enregistrées dans l'historique.
Un nouveau résultat est calculé à chaque tentative.

US24 — Consulter l'historique de mes quiz
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mes anciens résultats
Afin de retrouver tous les dieux protecteurs obtenus.
Priorité : Moyenne
Critères d'acceptation
Tous les résultats précédents sont affichés.
Chaque résultat indique le dieu obtenu.
Les résultats sont classés du plus récent au plus ancien.

EPIC 5 — Bibliothèque musicale
Objectif :
Permettre à l'Initié de découvrir et d'écouter les musiques inspirées de la mythologie celtique.

US25 — Accéder à la bibliothèque musicale
En tant que 🌿 Initié (Utilisateur)
Je souhaite accéder à la bibliothèque musicale
Afin de découvrir les musiques associées aux divinités.
Priorité : Moyenne
Critères d'acceptation
La bibliothèque musicale est accessible uniquement après connexion.
La liste des musiques est affichée.
Chaque musique est associée à un dieu.

US26 — Parcourir la bibliothèque musicale
En tant que 🌿 Initié (Utilisateur)
Je souhaite parcourir la liste des musiques
Afin de choisir celle que je souhaite écouter.
Priorité : Moyenne
Critères d'acceptation
La liste peut être parcourue.
Toutes les musiques sont visibles.
Les informations sont correctement affichées.

US27 — Écouter une musique
En tant que 🌿 Initié (Utilisateur)
Je souhaite écouter une musique
Afin de profiter d'une ambiance inspirée de la mythologie celtique.
Priorité : Haute
Critères d'acceptation
Une musique peut être lancée.
Une seule musique est jouée à la fois.
La lecture peut être arrêtée.

US28 — Consulter mes musiques favorites
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter les musiques présentes dans mes favoris
Afin de retrouver rapidement celles que j'ai enregistrées.
Priorité : Moyenne
Critères d'acceptation
La section « Mes musiques » est accessible depuis les favoris.
Toutes les musiques enregistrées sont affichées.
Une musique peut être sélectionnée.

US29 — Écouter une musique depuis mes favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite écouter une musique depuis mes favoris
Afin de retrouver facilement mes musiques préférées.
Priorité : Moyenne
Critères d'acceptation
Une musique peut être lancée depuis les favoris.
La lecture démarre correctement.
Une seule musique est jouée à la fois.

EPIC 6 — Gestion de l'Initié
Objectif :
Permettre à l'Initié de gérer son compte, son profil, ses favoris et de suivre sa progression au sein de Celticlopédie.
US30 — Créer un compte
En tant que 🍃 Voyageur (Visiteur)
Je souhaite créer un compte
Afin de devenir un Initié et accéder aux fonctionnalités réservées.
Priorité : Haute
Critères d'acceptation
Un formulaire d'inscription est disponible.
Les informations obligatoires sont demandées.
Les données sont validées.
Le compte est créé avec succès.

US31 — Se connecter
En tant que 🌿 Initié (Utilisateur)
Je souhaite me connecter
Afin d' accéder à mon espace personnel.
Priorité : Haute
Critères d'acceptation
Un formulaire de connexion est disponible.
Les identifiants sont vérifiés.
Une connexion réussie redirige vers le profil.
Un message d'erreur apparaît en cas d'échec.

US32 — Se déconnecter
En tant que 🌿 Initié (Utilisateur)
Je souhaite me déconnecter
Afin de sécuriser mon compte.
Priorité : Moyenne
Critères d'acceptation
Un bouton de déconnexion est disponible.
La session est fermée.
L'utilisateur est redirigé vers la page d'accueil.

US33 — Consulter mon profil
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mon profil
Afin de visualiser mes informations personnelles.
Priorité : Haute
Critères d'acceptation
Les informations du compte sont affichées.
Le profil est accessible uniquement après connexion.
Les informations sont correctement présentées.

US34 — Modifier mon profil
En tant que 🌿 Initié (Utilisateur)
Je souhaite modifier mes informations
Afin de maintenir mon profil à jour.
Priorité : Moyenne
Critères d'acceptation
Les informations modifiables sont affichées.
Les modifications sont enregistrées.
Une confirmation est affichée.

US35 — Modifier mon mot de passe
En tant que 🌿 Initié (Utilisateur)
Je souhaite modifier mon mot de passe
Afin de sécuriser mon compte.
Priorité : Moyenne
Critères d'acceptation
Le mot de passe actuel est demandé.
Le nouveau mot de passe est validé.
Le mot de passe est mis à jour.
Un message de confirmation est affiché.

US36 — Consulter mon Profil de l'Initié
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mon Profil de l'Initié
Afin de suivre ma progression.
Priorité : Moyenne
Critères d'acceptation
Le titre actuel est affiché.
Le titre précédent est affiché.
La progression est calculée automatiquement selon le nombre de favoris.

US37 — Consulter mes dieux favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mes dieux favoris
Afin de retrouver rapidement les divinités que j'ai enregistrées.
Priorité : Haute
Critères d'acceptation
La section « Mes Dieux » est accessible.
Tous les dieux favoris sont affichés.
Chaque dieu est consultable.

US38 — Consulter mes mythes favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mes mythes favoris
Afin de retrouver les récits que j'ai enregistrés.
Priorité : Moyenne
Critères d'acceptation
La section « Mes Mythes » est accessible.
Tous les mythes favoris sont affichés.
Chaque mythe est consultable.

US39 — Consulter mes symboles favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mes symboles favoris
Afin de retrouver ceux qui m'intéressent.
Priorité : Basse
Critères d'acceptation
La section « Mes Symboles » est accessible.
Tous les symboles favoris sont affichés.
Chaque symbole est consultable.

US40 — Consulter mes animaux favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter mes animaux favoris
Afin de retrouver ceux que j'ai enregistrés.
Priorité : Basse
Critères d'acceptation
La section « Mes Animaux » est accessible.
Tous les animaux favoris sont affichés.
Chaque animal est consultable.

US41 — Ajouter un élément aux favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite ajouter un élément à mes favoris
Afin de le retrouver facilement.
Priorité : Haute
Critères d'acceptation
Un bouton « Ajouter aux favoris » est disponible sur les éléments autorisés.
L'élément est enregistré.
Une confirmation est affichée.

US42 — Retirer un élément des favoris
En tant que 🌿 Initié (Utilisateur)
Je souhaite retirer un élément de mes favoris
Afin de mettre à jour ma collection.
Priorité : Moyenne
Critères d'acceptation
Un bouton « Retirer des favoris » est disponible.
L'élément est supprimé.
La liste est mise à jour automatiquement.

EPIC 7 — Administration du contenu
Objectif :
Permettre au 🌳 Grand Druide (Administrateur) de gérer l'ensemble des contenus de Celticlopédie.

US43 — Gérer les divinités
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les divinités
Afin de maintenir les informations de Celticlopédie à jour.
Priorité : Haute
Critères d'acceptation
Il est possible de créer une divinité.
Il est possible de modifier une divinité.
Il est possible de supprimer une divinité.
La liste des divinités est consultable.
Les modifications sont enregistrées en base de données.

US44 — Gérer les panthéons
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les panthéons
Afin de organiser les divinités selon leur origine.
Priorité : Moyenne
Critères d'acceptation
Création d'un panthéon.
Modification d'un panthéon.
Suppression d'un panthéon.
Consultation de la liste.

US45 — Gérer les symboles
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les symboles
Afin de compléter les informations des divinités.
Priorité : Moyenne
Critères d'acceptation
Création d'un symbole.
Modification d'un symbole.
Suppression d'un symbole.
Consultation de la liste.

US46 — Gérer le bestiaire
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les animaux
Afin de compléter le bestiaire.
Priorité : Moyenne
Critères d'acceptation
Création d'un animal.
Modification d'un animal.
Suppression d'un animal.
Consultation de la liste.

US47 — Gérer les mythes
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les mythes
Afin de enrichir les récits disponibles.
Priorité : Haute
Critères d'acceptation
Création d'un mythe.
Modification d'un mythe.
Suppression d'un mythe.
Consultation de la liste.

US48 — Gérer les chroniques
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les chroniques
Afin de proposer des récits détaillés.
Priorité : Moyenne
Critères d'acceptation
Création d'une chronique.
Modification d'une chronique.
Suppression d'une chronique.
Une chronique est associée à un seul mythe.

US49 — Gérer les savoirs préservés
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les savoirs préservés
Afin de enrichir les connaissances proposées aux visiteurs.
Priorité : Moyenne
Critères d'acceptation
Création d'un savoir.
Modification d'un savoir.
Suppression d'un savoir.
Un seul savoir peut être défini comme « Focus du mois ».

US50 — Gérer la bibliothèque musicale
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les musiques
Afin de maintenir la bibliothèque musicale.
Priorité : Moyenne
Critères d'acceptation
Création d'une musique.
Modification d'une musique.
Suppression d'une musique.
Chaque musique est associée à un dieu.

US51 — Gérer le quiz
En tant que 🌳 Grand Druide (Administrateur)
Je souhaite gérer les questions et les réponses du quiz
Afin de faire évoluer le questionnaire.
Priorité : Haute
Critères d'acceptation
Création d'une question.
Modification d'une question.
Suppression d'une question.
Création d'une réponse.
Modification d'une réponse.
Suppression d'une réponse.
Chaque réponse attribue un nombre de points à un dieu.

EPIC 8 — Archives du Druide
Objectif :
Permettre aux utilisateurs d'explorer les contenus culturels de Celticlopédie.

US52 — Consulter les Chroniques Mythologiques
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter les Chroniques Mythologiques
Afin de découvrir les récits détaillés de la mythologie celtique.
Priorité : Moyenne
Critères d'acceptation
Les chroniques sont accessibles.
Une liste des chroniques est affichée.
Chaque chronique peut être ouverte.

US53 — Lire une chronique
En tant que 🌿 Initié (Utilisateur)
Je souhaite lire une chronique
Afin de découvrir l'histoire complète d'un mythe.
Priorité : Moyenne
Critères d'acceptation
Le contenu complet de la chronique est affiché.
Le mythe associé est identifiable.
La lecture est fluide.

US54 — Consulter les Savoirs Préservés
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter les Savoirs Préservés
Afin d' approfondir mes connaissances sur la culture celtique.
Priorité : Moyenne
Critères d'acceptation
Les savoirs sont accessibles.
Une liste est affichée.
Chaque savoir peut être consulté.

US55 — Consulter le Focus du mois
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter le Focus du mois
Afin de découvrir le savoir mis en avant.
Priorité : Basse
Critères d'acceptation
Le savoir du mois est affiché.
Un seul savoir est présenté.
Le contenu complet est consultable.

US56 — Parcourir les cycles mythologiques
En tant que 🌿 Initié (Utilisateur)
Je souhaite parcourir les cycles mythologiques
Afin de découvrir les mythes regroupés par cycle.
Priorité : Moyenne
Critères d'acceptation
Les cycles sont affichés.
Chaque cycle est consultable.
Les mythes appartenant au cycle sont visibles.

US57 — Consulter les mythes par catégorie
En tant que 🌿 Initié (Utilisateur)
Je souhaite consulter les mythes par catégorie
Afin de découvrir les récits selon leur thème.
Priorité : Moyenne
Critères d'acceptation
Les catégories « Dieux & Nature », « Héros » et « Rois » sont proposées.
Les mythes sont classés dans la bonne catégorie.
La sélection d'une catégorie affiche uniquement les mythes correspondants.

4. SPÉCIFICATIONS TECHNIQUES
   Stack Technique

Frontend :
Twig (moteur de templates Symfony)
HTML5
CSS3
JavaScript
CSS / Tailwind

Backend :
PHP 8.x
Symfony 7

Base de données :
MySQL
ORM :
Doctrine ORM

Gestion des dépendances :
Composer

Architecture :

Navigateur Web
↓
Application Symfony (MVC)
↓
Doctrine ORM
↓
Base de données relationnelle (MySQL)

Architecture logicielle :

Modèle : Entités Doctrine et base de données MySQL
Vue : Templates Twig
Contrôleur : Contrôleurs Symfony

Base de données

## Utilisateurs

users
favorites

## Quiz

quizzes
questions
answers
quiz_results

## Divinités

gods
pantheons
god_pantheon

symbols
god_symbol

animals
god_animal

myths
god_myth
cycle_mythique
chroniques

musics

knowledges

(ENDPOINTS) Routes de l'application Symfony :

GET /
GET /dieux
GET /dieux/{id}
GET /panthéons
GET /symboles
GET /animaux
GET /mythes
GET /musiques

GET|POST /inscription
GET|POST /connexion
GET /déconnexion

GET /profil
GET /favoris
GET /quiz
GET /historique
GET /chroniques
GET /chroniques/{id}
GET /savoirs
GET /savoirs/{id}
GET /archives-du-druide
GET /quiz/resultat
GET /cycles
GET /cycles/{id}

GET /admin
GET /admin/dieux
GET /admin/pantheons
GET /admin/symboles
GET /admin/animaux
GET /admin/mythes
GET /admin/musiques
GET /admin/questions
GET /admin/reponses
GET /admin/chroniques
GET /admin/savoirs
GET /admin/cycles

Qualité du code

- Code structuré
- Respect de l'architecture MVC
- Nommage clair
- Réutilisation des composants
- Respect des conventions Symfony

Sécurité & Performance (simple)

- Validation des données
- Gestion des erreurs
- Requêtes optimisées
- Authentification Symfony Security
- Gestion des rôles (ROLE_USER, ROLE_ADMIN)
- Hashage des mots de passe
- Protection des pages administrateur
- Validation des formulaires

Outils de développement :

- Symfony CLI
- Composer
- Git
- GitHub
- phpMyAdmin
- Figma
- Draw.io
- Visual Studio Code

5. INTERFACE UTILISATEUR

- Design inspiré du monde celtique
- Style parchemin
- Navigation claire
- Responsive (mobile + desktop)
- Compatible mobile
- Compatible tablette
- Compatible desktop

6. CONTRAINTES

- Temps limité
- Projet individuel
- Complexité maîtrisée

7. CRITÈRES DE RÉUSSITE

- Application fonctionnelle
- Navigation fluide
- Communication correcte entre Symfony et la base de données.
- Données cohérentes
- Design exploitable
- Authentification fonctionnelle
- Gestion des favoris opérationnelle
- Le Profil de l'Initié évolue automatiquement selon le nombre de favoris enregistrés.

8. PLANIFICATION

Phases :

- Conception
- Backend
- Frontend
- Intégration des données et connexion à la base de données
- Tests et corrections

  9.UML ET MODÉLISATION DES DONNÉES
  Diagrammes réalisés :

Diagramme de cas d'utilisation (Use Case UML)
Modèle Conceptuel de Données (MCD)
Modèle Logique de Données (MLD)
Schéma relationnel de la base de données

Le diagramme de cas d'utilisation permet d'identifier les interactions entre les différents acteurs du système :
Acteurs :

Visiteur
Utilisateur connecté
Administrateur

Fonctionnalités principales :

Visiteur :

Consulter les divinités
Effectuer des recherches
Filtrer les résultats
Consulter les fiches détaillées

Utilisateur :

Créer un compte
Se connecter
Réaliser le quiz
Sauvegarder des favoris
Accéder à la bibliothèque musicale.
Consulter son Profil de l'Initié
Ajouter des favoris
Retirer des favoris
Consulter les Chroniques
Consulter les Savoirs Préservés
Consulter le Focus du mois

Administrateur :

Gérer les divinités
Gérer les symboles
Gérer les animaux
Gérer les mythes
Gérer les musiques
Gérer les panthéons
Gérer les Chroniques
Gérer les Savoirs Préservés
Gérer les Cycles Mythologiques
Le modèle de données est basé sur une architecture relationnelle MySQL permettant de gérer les relations entre les divinités, les symboles, les animaux, les mythes, les utilisateurs et les résultats de quiz. 10. Les règles métier

Un dieu possède une seule musique.
Un dieu peut appartenir à plusieurs panthéons.
Un dieu peut être associé à plusieurs symboles.
Un dieu peut être associé à plusieurs animaux.
Un mythe peut concerner plusieurs dieux.
Une chronique raconte un seul mythe.
Les savoirs préservés ne peuvent pas être ajoutés aux favoris.
Un seul savoir peut être défini comme « Focus du mois ».
Le titre du Profil de l'Initié dépend uniquement du nombre de favoris de l'utilisateur.
Le résultat du quiz correspond au dieu ayant obtenu le plus de points.
L'utilisateur choisit librement d'ajouter ou non son dieu protecteur à ses favoris.
Chaque réponse attribue un nombre de points à un dieu.
Un quiz contient plusieurs questions.
Une question possède plusieurs réponses.
Les favoris peuvent contenir uniquement :

- un dieu
- un mythe
- un symbole
- un animal
- une musique
  Les chroniques sont rattachées à un unique mythe.
  Les cycles mythologiques regroupent plusieurs mythes.
  Les mythes sont classés dans une catégorie :
- Dieux & Nature
- Héros
- Rois
  Chaque utilisateur possède un Profil de l'Initié calculé automatiquement à partir du nombre de favoris enregistrés.
  Le Focus du mois correspond au savoir préservé dont le champ is_focus est défini à true.
