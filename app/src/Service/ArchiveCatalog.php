<?php

namespace App\Service;

use App\Entity\Savoir;

final class ArchiveCatalog
{
    private const CATEGORIES = [
        'history' => ['label' => 'Études, sociétés & histoire', 'description' => 'Civilisations, sociétés et transmission de la mémoire celtique.'],
        'myths' => ['label' => 'Mythes, cycles & Autre Monde', 'description' => 'Cycles légendaires, souveraineté et passages vers l’invisible.'],
        'ogham' => ['label' => 'Ogham, arbres & nature', 'description' => 'Alphabet sacré, arbres tutélaires et lieux oghamiques.'],
        'divination' => ['label' => 'Divination, prophéties & astronomie', 'description' => 'Oracles, présages, configurations et lecture du ciel.'],
        'rites' => ['label' => 'Rites, spiritualité & médecine', 'description' => 'Pratiques rituelles, guérison et chemins spirituels.'],
        'manuscripts' => ['label' => 'Textes, manuscrits & inscriptions', 'description' => 'Livres anciens, transmission écrite et traces archéologiques.'],
        'arts' => ['label' => 'Arts sacrés, musique & symboles', 'description' => 'Entrelacs, forge, nombres et puissances musicales.'],
    ];

    private const TITLE_CATEGORIES = [
        'La Quête du Graal Celte' => ['myths', 'manuscripts'],
        'Les Cycles Arthuriens et leurs Racines Celtiques' => ['myths', 'history'],
        'La Femme dans la Société Celtique' => ['history', 'rites'],
        'Les Druides — Mythes et Réalités' => ['history', 'rites'],
        "La Mort et l'Au-delà dans la Pensée Celtique" => ['myths', 'rites'],
        'Les Vikings et les Celtes — Rencontres et Influences' => ['history', 'myths'],
        "L'Héritage Celtique dans la Culture Moderne" => ['history', 'arts'],
        'Les Fomoriens — Les Ennemis des Dieux' => ['myths', 'history'],
        'La Souveraineté Sacrée — Le Roi et la Terre' => ['myths', 'rites', 'history'],
        'Les Celtes et Rome — Conquête et Résistance' => ['history', 'manuscripts'],
        'La Transmission Orale — Comment les Mythes Ont Survécu' => ['manuscripts', 'history'],
        "Le Renouveau Celtique — De la Renaissance à Aujourd'hui" => ['history', 'arts'],
        'Le Chant des Chênes' => ['ogham', 'manuscripts'],
        "L'Oracle de Brigid" => ['divination', 'myths'],
        'Grimoire des Herbes de Lune' => ['rites', 'ogham'],
        'Géométrie des Entrelacs' => ['arts', 'manuscripts'],
        "L'Art de la Prophétie Druidique" => ['divination', 'rites'],
        'Les Fêtes Sacrées du Calendrier Celtique' => ['rites', 'divination'],
        "L'Écriture Ogham Décodée" => ['ogham', 'divination', 'manuscripts'],
        'Les Quatre Villes Mythiques du Nord' => ['myths'],
        "Le Code d'Honneur des Fianna" => ['myths', 'history'],
        'Les Trois Fonctions Sacrées' => ['rites', 'history'],
        "Les Portes de l'Autre Monde" => ['myths', 'rites'],
        'Le Langage Secret des Arbres' => ['ogham', 'rites'],
        'Les Triades Celtiques' => ['manuscripts', 'history'],
        "L'Art de la Forge Druidique" => ['arts', 'rites'],
        'Les Nombres Sacrés' => ['arts', 'divination'],
        'La Musique des Sphères Celtiques' => ['arts', 'rites'],
        'Les Rites de Passage Celtiques' => ['rites', 'history'],
        'La Médecine des Druides' => ['rites', 'ogham'],
        'Les Inscriptions Sacrées de Gaule' => ['manuscripts', 'history', 'arts'],
        "L'Astronomie Druidique" => ['divination', 'arts'],
        'Parchemins Anciens' => ['manuscripts', 'history'],
        'Alphabet Ogham' => ['ogham', 'divination', 'manuscripts'],
        "Secrets d'Avalon" => ['myths', 'rites'],
        'Prophéties' => ['divination', 'myths'],
        'Sagesse Druidique' => ['rites', 'myths', 'ogham'],
    ];

    public function __construct(private readonly SavoirDossierPresenter $dossierPresenter)
    {
    }

    /**
     * @param list<Savoir> $officialSavoirs
     * @param list<Savoir> $discoveries
     * @param list<Savoir> $dossiers
     * @return array{categories: list<array<string, mixed>>, dossiers: list<array<string, mixed>>, entries: list<array<string, mixed>>, readingCount: int, nodeCount: int}
     */
    public function build(array $officialSavoirs, array $discoveries, array $dossiers): array
    {
        $entries = [];

        foreach ($officialSavoirs as $savoir) {
            $entries[] = $this->savoirEntry($savoir, 'Étude approfondie');
        }
        foreach ($discoveries as $savoir) {
            $entries[] = $this->savoirEntry($savoir, 'Découverte documentaire');
        }
        foreach ($dossiers as $savoir) {
            $entries[] = $this->savoirEntry($savoir, 'Dossier complet');
            array_push($entries, ...$this->dossierEntries($savoir));
        }

        $categories = [];
        foreach (self::CATEGORIES as $key => $category) {
            $category['key'] = $key;
            $category['count'] = count(array_filter(
                $entries,
                static fn (array $entry): bool => $entry['isReading'] && in_array($key, $entry['categories'], true),
            ));
            $categories[] = $category;
        }

        return [
            'categories' => $categories,
            'dossiers' => array_values(array_filter(array_map($this->dossierNavigation(...), $dossiers))),
            'entries' => $entries,
            'readingCount' => count(array_filter($entries, static fn (array $entry): bool => $entry['isReading'])),
            'nodeCount' => count($entries),
        ];
    }

    /** @return array<string, mixed>|null */
    private function dossierNavigation(Savoir $savoir): ?array
    {
        $presentation = $this->dossierPresenter->present($savoir);
        if ($presentation === null) {
            return null;
        }

        $sections = [];
        foreach ($presentation['blocks'] as $block) {
            if ($block['type'] === 'text') {
                $sections[] = [
                    'type' => 'links',
                    'title' => $block['title'],
                    'items' => [$this->navigationItem($block['title'], $block['body'], $block['anchor'])],
                ];
            } elseif (in_array($block['type'], ['collection', 'list'], true)) {
                $sections[] = [
                    'type' => 'links',
                    'title' => $block['title'],
                    'items' => array_map(fn (array $item): array => $this->navigationItem(
                        $item['title'] ?? $item['label'],
                        $item['body'] ?? $item['value'],
                        $item['anchor'],
                    ), $block['items']),
                ];
            } elseif (in_array($block['type'], ['aicmes', 'wisdom'], true)) {
                $sections[] = [
                    'type' => 'groups',
                    'title' => $block['title'],
                    'groups' => array_map(fn (array $group): array => [
                        'title' => $group['title'],
                        'anchor' => $group['anchor'],
                        'items' => array_map(fn (array $item): array => $this->navigationItem(
                            isset($item['name']) ? $item['name'].' — '.$item['tree'] : $item['title'],
                            $item['meaning'] ?? 'Accéder directement à ce passage.',
                            $item['anchor'],
                        ), $group['items']),
                    ], $block['groups']),
                ];
            }
        }

        return [
            'id' => $savoir->getId(),
            'title' => $savoir->getTitle(),
            'summary' => $savoir->getSummary(),
            'meta' => $this->dossierMeta($savoir, $sections),
            'sections' => $sections,
        ];
    }

    /** @param list<array<string, mixed>> $sections */
    private function dossierMeta(Savoir $savoir, array $sections): string
    {
        $groupCount = 0;
        $itemCount = 0;
        foreach ($sections as $section) {
            if ($section['type'] === 'groups') {
                $groupCount += count($section['groups']);
                foreach ($section['groups'] as $group) {
                    $itemCount += count($group['items']);
                }
            } else {
                $itemCount += count($section['items']);
            }
        }

        return match ($savoir->getTitle()) {
            'Parchemins Anciens' => ($itemCount - 1).' parchemins',
            'Alphabet Ogham' => $groupCount.' Aicme · 20 lettres · Divination · 4 sites',
            "Secrets d'Avalon" => ($itemCount - 1).' secrets',
            'Prophéties' => ($itemCount - 1).' prophéties',
            'Sagesse Druidique' => $itemCount.' sagesses · '.$groupCount.' thèmes',
            default => $itemCount.' contenus',
        };
    }

    /** @return array{title: string, summary: string, anchor: string} */
    private function navigationItem(string $title, string $summary, string $anchor): array
    {
        return ['title' => $title, 'summary' => $this->excerpt($summary), 'anchor' => $anchor];
    }

    /** @return array<string, mixed> */
    private function savoirEntry(Savoir $savoir, string $type): array
    {
        return $this->entry(
            'savoir-'.$savoir->getId(),
            (string) $savoir->getTitle(),
            (string) $savoir->getSummary(),
            $type,
            $savoir,
            null,
            self::TITLE_CATEGORIES[$savoir->getTitle()] ?? [],
            true,
        );
    }

    /** @return list<array<string, mixed>> */
    private function dossierEntries(Savoir $savoir): array
    {
        $presentation = $this->dossierPresenter->present($savoir);
        if ($presentation === null) {
            return [];
        }

        $entries = [];
        foreach ($presentation['blocks'] as $block) {
            if ($block['type'] === 'text') {
                $isPresentation = str_contains((string) $block['title'], 'Présentation');
                $entries[] = $this->entry(
                    $block['anchor'],
                    $isPresentation ? 'Présentation de '.$savoir->getTitle() : $block['title'],
                    $this->excerpt($block['body']),
                    $isPresentation ? 'Repère du dossier' : 'Section à lire',
                    $savoir,
                    $block['anchor'],
                    $this->categoriesForBlock($savoir, $block),
                    !$isPresentation,
                );
            } elseif ($block['type'] === 'collection') {
                foreach ($block['items'] as $item) {
                    $entries[] = $this->entry($item['anchor'], $item['title'], $this->excerpt($item['body']), $this->childType($savoir), $savoir, $item['anchor'], $this->categoriesForBlock($savoir, $block), true);
                }
            } elseif ($block['type'] === 'aicmes') {
                foreach ($block['groups'] as $group) {
                    $entries[] = $this->entry($group['anchor'], $group['title'], 'Regroupement de cinq lettres oghamiques.', 'Repère — Aicme', $savoir, $group['anchor'], ['ogham'], false);
                    foreach ($group['items'] as $letter) {
                        $entries[] = $this->entry($letter['anchor'], $letter['name'].' — '.$letter['tree'], $this->excerpt($letter['meaning']), 'Lettre Ogham · '.$letter['letter'], $savoir, $letter['anchor'], ['ogham'], true);
                    }
                }
            } elseif ($block['type'] === 'list') {
                foreach ($block['items'] as $item) {
                    $isSite = str_contains(mb_strtolower((string) $block['title']), 'site');
                    $entries[] = $this->entry($item['anchor'], $item['label'], $this->excerpt($item['value']), $isSite ? 'Site oghamique' : 'Configuration divinatoire', $savoir, $item['anchor'], $isSite ? ['ogham', 'manuscripts'] : ['ogham', 'divination'], true);
                }
            } elseif ($block['type'] === 'wisdom') {
                foreach ($block['groups'] as $group) {
                    $categories = $this->wisdomCategories($group['title']);
                    $entries[] = $this->entry($group['anchor'], $group['title'], count($group['items']).' sagesses conservées.', 'Repère — Thème', $savoir, $group['anchor'], $categories, false);
                    foreach ($group['items'] as $index => $wisdom) {
                        $entries[] = $this->entry($wisdom['anchor'], $wisdom['title'], 'Sagesse '.($index + 1).' du thème « '.$group['title'].' ».', 'Sagesse druidique', $savoir, $wisdom['anchor'], $categories, true);
                    }
                }
            }
        }

        return $entries;
    }

    /** @return array<string, mixed> */
    private function entry(string $id, string $title, string $summary, string $type, Savoir $parent, ?string $anchor, array $categories, bool $isReading): array
    {
        return [
            'id' => $id,
            'title' => $title,
            'summary' => $summary,
            'type' => $type,
            'parentId' => $parent->getId(),
            'parentTitle' => $anchor === null ? null : $parent->getTitle(),
            'anchor' => $anchor,
            'categories' => array_values(array_unique($categories)),
            'isReading' => $isReading,
        ];
    }

    /** @return list<string> */
    private function categoriesForBlock(Savoir $savoir, array $block): array
    {
        if ($savoir->getTitle() === 'Alphabet Ogham' && ($block['anchor'] ?? null) === 'ogham-divination') {
            return ['ogham', 'divination'];
        }

        return self::TITLE_CATEGORIES[$savoir->getTitle()] ?? [];
    }

    private function childType(Savoir $savoir): string
    {
        return match ($savoir->getTitle()) {
            'Parchemins Anciens' => 'Parchemin ancien',
            "Secrets d'Avalon" => 'Secret d’Avalon',
            'Prophéties' => 'Prophétie',
            default => 'Contenu du dossier',
        };
    }

    /** @return list<string> */
    private function wisdomCategories(string $theme): array
    {
        return match ($theme) {
            'La Nature et les Arbres', "L'Eau et les Sources" => ['ogham', 'rites'],
            'Le Temps et les Cycles', 'La Sagesse et la Connaissance' => ['rites', 'divination'],
            'Le Courage et la Guerre' => ['myths', 'history'],
            'La Royauté et le Pouvoir' => ['myths', 'history', 'rites'],
            "La Mort et l'Autre Monde" => ['myths', 'rites'],
            default => ['rites'],
        };
    }

    private function excerpt(string $text): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? $text);

        return mb_strlen($text) > 180 ? mb_substr($text, 0, 177).'…' : $text;
    }
}
