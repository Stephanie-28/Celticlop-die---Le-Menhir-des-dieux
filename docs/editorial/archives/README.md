# Corpus éditorial — Archives du Druide

Ce dossier conserve les sources éditoriales destinées aux futures **Archives du Druide**. Il est documentaire : aucun fichier présent ici n'est chargé automatiquement par Symfony et aucune donnée n'est importée en base.

## Sources autorisées

- Source canonique initiale : `Celticlopedie_Contenu_Complet.pdf` — 42 pages.
- SHA-256 : `82dcf69004d4e808b0e844b7a408bf9409d1289f2ba1ea951e0dad4022718e12`.
- Les fichiers `Celticlopedie_Contenu_Complet.pdf`, `Celticlopedie_Contenu_Complet-1.pdf` et `Celticlopedie_Contenu_Complet-2.pdf` sont trois copies binaires strictement identiques. Une seule version logique est donc référencée.
- Source complémentaire autorisée le 25 août 2026 : `Archives_du_Druide_Documentation_Complete_Codex.pdf` — 110 pages.
- Cette source complémentaire fournit les textes longs des 12 Savoirs officiels, de 5 Découvertes et les versions complètes de 4 Dossiers.

## Règles de conservation

- Le texte disponible est conservé sans reformulation.
- `FULL_TEXT_MISSING` signifie que le PDF ne fournit qu'un résumé : aucun corps d'article n'a été inventé.
- La mention ancienne « Focus du Mois — Étude Approfondie » n'est pas une propriété des douze études. Leur libellé éditorial actuel est « Savoir Préservé — Étude approfondie ».
- Les anciennes architectures remplacées par le site actuel restent inventoriées comme `LEGACY_SOURCE_ONLY`.
- Les 40 Chroniques sont inventoriées mais destinées à **Chroniques Mythiques**, jamais à l'entité `Savoir`.

## Organisation

- [`manifest.md`](manifest.md) : inventaire, statut des textes, doublons et destination future.
- [`savoirs/12-savoirs-officiels.md`](savoirs/12-savoirs-officiels.md) et [`savoirs/officiels/`](savoirs/officiels/) : index et textes longs des 12 études officielles.
- [`savoirs/20-dernieres-decouvertes.md`](savoirs/20-dernieres-decouvertes.md) et [`savoirs/decouvertes/`](savoirs/decouvertes/) : index des 20 Découvertes et 5 textes longs disponibles.
- [`dossiers/`](dossiers/) : cinq portes d'entrée éditoriales des Archives.
- [`sagesses/70-sagesses.md`](sagesses/70-sagesses.md) : corpus unique des 70 phrases.
- [`chroniques/40-chroniques.md`](chroniques/40-chroniques.md) : inventaire uniquement.
- [`legacy/`](legacy/) : anciennes structures remplacées, conservées comme sources.
