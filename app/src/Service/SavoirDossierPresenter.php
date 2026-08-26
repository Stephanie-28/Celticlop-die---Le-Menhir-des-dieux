<?php

namespace App\Service;

use App\Entity\Savoir;
use App\Enum\SavoirEditorialType;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class SavoirDossierPresenter
{
    /** @return array<string, mixed>|null */
    public function present(Savoir $savoir): ?array
    {
        if ($savoir->getEditorialType() !== SavoirEditorialType::DOSSIER) {
            return null;
        }

        return match ($savoir->getTitle()) {
            'Parchemins Anciens' => $this->parchments($savoir),
            'Alphabet Ogham' => $this->ogham($savoir),
            "Secrets d'Avalon" => $this->avalon($savoir),
            'Prophéties' => $this->prophecies($savoir),
            'Sagesse Druidique' => $this->wisdom($savoir),
            default => null,
        };
    }

    /** @return array<string, mixed> */
    private function parchments(Savoir $savoir): array
    {
        $content = $this->normalize($savoir->getContent());
        [$main] = $this->splitOnce($content, 'État de déblocage :');
        [$introduction, $documents] = $this->splitOnce($main, 'Les Parchemins disponibles :');
        $titles = [
            'Le Livre de la Vache Brune (Lebor na hUidre)',
            'Le Livre de Leinster',
            'Le Livre de Ballymote',
            'Les Acallam na Senórach',
            'Le Mabinogi',
            'Le Calendrier de Coligny',
        ];

        return $this->view(
            'Reliques d’écriture sacrée',
            'Des fragments de sagesse arrachés à l’oubli — des textes dont chaque mot porte le poids de siècles de transmission et de préservation.',
            [
                $this->textBlock('Présentation complète', $this->withoutPrefix($introduction, 'Présentation complète :'), 'parchemins-presentation'),
                $this->collectionBlock('Les parchemins disponibles', $this->extractNamedSections($documents, $titles, false, 'parchemin')),
            ],
        );
    }

    /** @return array<string, mixed> */
    private function ogham(Savoir $savoir): array
    {
        $content = $this->normalize($savoir->getContent());
        [$beforeUnlock] = $this->splitOnce($content, 'État de déblocage :');
        [$beforeSites, $sitesText] = $this->splitOnce($beforeUnlock, 'Les Sites Oghamiques Majeurs :');
        [$beforeReading, $readingText] = $this->splitOnce($beforeSites, 'Comment lire les baguettes :');
        [$beforeDivination, $divination] = $this->splitOnce($beforeReading, "L'Ogham comme Outil Divinatoire :");
        [$introduction, $lettersText] = $this->splitOnce($beforeDivination, 'Le Guide Complet des 20 Lettres :');

        $letters = [
            ['B', 'Beith', 'Bouleau'], ['L', 'Luis', 'Sorbier'], ['N', 'Nion', 'Frêne'], ['F', 'Fearn', 'Aulne'], ['S', 'Sail', 'Saule'],
            ['H', 'Huath', 'Aubépine'], ['D', 'Dair', 'Chêne'], ['T', 'Tinne', 'Houx'], ['C', 'Coll', 'Noisetier'], ['Q', 'Quert', 'Pommier'],
            ['M', 'Muin', 'Vigne'], ['G', 'Gort', 'Lierre'], ['R', 'Ruis', 'Sureau'], ['A', 'Ailm', 'Pin'], ['O', 'Onn', 'Ajonc'],
            ['U', 'Ur', 'Bruyère'], ['E', 'Edad', 'Peuplier'], ['I', 'Idad', 'If'], ['EA', 'Ebad', 'Tremble'], ['OI', 'Oir', 'Épine'],
        ];
        $letterRows = $this->extractLetterMeanings($lettersText, $letters);
        $aicmes = [
            ['title' => 'Premier Aicme — Les Arbres de Force', 'anchor' => 'ogham-premier-aicme', 'items' => array_slice($letterRows, 0, 5)],
            ['title' => 'Deuxième Aicme — Les Arbres de Sagesse', 'anchor' => 'ogham-deuxieme-aicme', 'items' => array_slice($letterRows, 5, 5)],
            ['title' => 'Troisième Aicme — Les Arbres de Transformation', 'anchor' => 'ogham-troisieme-aicme', 'items' => array_slice($letterRows, 10, 5)],
            ['title' => 'Quatrième Aicme — Les Arbres du Mystère', 'anchor' => 'ogham-quatrieme-aicme', 'items' => array_slice($letterRows, 15, 5)],
        ];

        return $this->view(
            'L’écriture sacrée des druides',
            'Vingt lettres taillées dans le bois et la pierre — chacune un arbre, chacune un monde.',
            [
                $this->textBlock('Présentation complète', $this->withoutPrefix($introduction, 'Présentation complète :'), 'ogham-presentation'),
                ['type' => 'aicmes', 'title' => 'Le guide complet des 20 lettres', 'groups' => $aicmes],
                $this->textBlock("L’Ogham comme outil divinatoire", $divination, 'ogham-divination'),
                $this->listBlock('Comment lire les baguettes', $this->withAnchors($this->extractArrowItems($readingText, [
                    '3 baguettes alignées', 'Baguettes croisées', 'Baguettes éparpillées', 'Une seule baguette isolée',
                ]), 'ogham-configuration')),
                $this->listBlock('Les sites oghamiques majeurs', $this->withAnchors($this->extractDashItems($sitesText, [
                    'Ogham Stone de Dunloe', 'Ogham Stone de Kilmalkedar', 'Ogham Stones de Breccán', 'Pillar Stone de Nevern',
                ]), 'ogham-site')),
            ],
        );
    }

    /** @return array<string, mixed> */
    private function avalon(Savoir $savoir): array
    {
        $content = $this->normalize($savoir->getContent());
        [$main] = $this->splitOnce($content, 'État de déblocage :');
        [$introduction, $secrets] = $this->splitOnce($main, 'Les Secrets disponibles :');
        $titles = [
            'Secret I — La Nature du Voile',
            'Secret II — Le Temps de l’Autre Monde',
            'Secret III — Les Neuf Femmes d’Avalon',
            'Secret IV — Le Paradoxe du Retour',
            'Secret V — La Pomme d’Emain Ablach',
            'Secret VI — Pourquoi Arthur Dort',
        ];

        return $this->view(
            'Les mystères de l’île enchantée et de l’Autre Monde',
            'Au-delà de l’horizon occidental, là où la mer rencontre le ciel, se trouvent des vérités que seuls les plus avancés peuvent recevoir.',
            [
                $this->textBlock('Présentation complète', $this->withoutPrefix($introduction, 'Présentation complète :'), 'avalon-presentation'),
                $this->collectionBlock('Les six secrets', $this->extractNamedSections($secrets, $titles, true, 'avalon')),
            ],
            'Six enseignements ésotériques sur l’Autre Monde issus de la tradition celtique.',
        );
    }

    /** @return array<string, mixed> */
    private function prophecies(Savoir $savoir): array
    {
        $content = $this->normalize($savoir->getContent());
        [$main] = $this->splitOnce($content, 'État de déblocage :');
        [$introduction, $prophecies] = $this->splitOnce($main, 'Les Grandes Prophéties de la Tradition Celtique :');
        $titles = [
            'Prophétie I — La Prophétie de Cathbad sur Deirdre',
            'Prophétie II — La Prophétie de Fedelm à la Reine Medb',
            'Prophétie III — La Prophétie de Balor',
            'Prophétie IV — La Prophétie de la Morrigan après Mag Tuired',
            'Prophétie V — La Prophétie de Merlin sur les Deux Dragons',
            'Prophétie VI — La Prophétie de la Pierre de Fal',
            'Prophétie VII — L’Oracle de Brigit sur l’Avenir de l’Irlande',
            'Prophétie VIII — La Prophétie du Crépuscule des Dieux',
        ];
        return $this->view(
            'Les grandes prophéties et oracles de la tradition celtique',
            'Ce qui fut dit avant que cela n’arrive — les voix des voyants qui percèrent le voile du temps pour nous transmettre ce que nous n’étions pas encore prêts à voir.',
            [
                $this->textBlock('Présentation complète', $this->withoutPrefix($introduction, 'Présentation complète :'), 'propheties-presentation'),
                $this->collectionBlock('Les huit prophéties', $this->extractNamedSections($prophecies, $titles, true, 'prophetie')),
            ],
        );
    }

    /** @return array<string, mixed> */
    private function wisdom(Savoir $savoir): array
    {
        $themes = [
            'La Nature et les Arbres', "L'Eau et les Sources", 'Le Temps et les Cycles', 'Le Courage et la Guerre',
            'La Sagesse et la Connaissance', 'La Royauté et le Pouvoir', "La Mort et l'Autre Monde",
        ];

        return $this->view(
            'Sept chemins de sagesse druidique',
            'Soixante-douze phrases uniques inspirées de la tradition celtique et druidique, organisées en sept thèmes.',
            [['type' => 'wisdom', 'title' => 'Les 72 sagesses', 'groups' => $this->extractWisdom($this->normalize($savoir->getContent()), $themes)]],
        );
    }

    /** @param list<array<string, mixed>> $blocks @return array<string, mixed> */
    private function view(string $subtitle, string $description, array $blocks, ?string $publicSummary = null): array
    {
        return [
            'positioning' => 'Savoirs Préservés — Archives du Druide',
            'subtitle' => $subtitle,
            'description' => $description,
            'publicSummary' => $publicSummary,
            'blocks' => array_values(array_filter($blocks, static fn (array $block): bool => ($block['body'] ?? $block['items'] ?? $block['rows'] ?? $block['groups'] ?? null) !== null)),
        ];
    }

    /** @return array{type: string, title: string, body: string, anchor: string|null} */
    private function textBlock(string $title, string $body, ?string $anchor = null): array
    {
        return ['type' => 'text', 'title' => $title, 'body' => trim($body), 'anchor' => $anchor];
    }

    /** @param list<array{title: string, body: string}> $items @return array<string, mixed> */
    private function collectionBlock(string $title, array $items): array
    {
        return ['type' => 'collection', 'title' => $title, 'items' => $items];
    }

    /** @param list<array{label: string, value: string}> $items @return array<string, mixed> */
    private function listBlock(string $title, array $items): array
    {
        return ['type' => 'list', 'title' => $title, 'items' => $items];
    }

    private function normalize(?string $content): string
    {
        return trim(str_replace(["\r\n", "\r", '’'], ["\n", "\n", "'"], (string) $content));
    }

    /** @return array{string, string} */
    private function splitOnce(string $content, string $marker): array
    {
        $normalizedMarker = str_replace('’', "'", $marker);
        $position = mb_strpos($content, $normalizedMarker);
        if ($position === false) {
            return [$content, ''];
        }

        return [trim(mb_substr($content, 0, $position)), trim(mb_substr($content, $position + mb_strlen($normalizedMarker)))];
    }

    private function withoutPrefix(string $content, string $prefix): string
    {
        return str_starts_with($content, $prefix) ? trim(substr($content, strlen($prefix))) : trim($content);
    }

    /** @param list<string> $titles @return list<array{title: string, body: string, anchor: string}> */
    private function extractNamedSections(string $content, array $titles, bool $normalizeApostrophes = false, string $anchorPrefix = 'archive'): array
    {
        $working = $normalizeApostrophes ? str_replace('’', "'", $content) : $content;
        $normalizedTitles = array_map(static fn (string $title): string => $normalizeApostrophes ? str_replace('’', "'", $title) : $title, $titles);
        $items = [];

        foreach ($normalizedTitles as $index => $title) {
            $start = mb_strpos($working, $title);
            if ($start === false) {
                continue;
            }
            $bodyStart = $start + mb_strlen($title);
            $nextTitle = $normalizedTitles[$index + 1] ?? null;
            $end = $nextTitle === null ? mb_strlen($working) : mb_strpos($working, $nextTitle, $bodyStart);
            $items[] = [
                'title' => $titles[$index],
                'body' => trim(mb_substr($working, $bodyStart, ($end === false ? mb_strlen($working) : $end) - $bodyStart)),
                'anchor' => $this->anchor($anchorPrefix, $titles[$index]),
            ];
        }

        return $items;
    }

    /** @param list<array{string, string, string}> $letters @return list<array{letter: string, name: string, tree: string, meaning: string, anchor: string}> */
    private function extractLetterMeanings(string $content, array $letters): array
    {
        $flat = preg_replace('/\s+/u', ' ', $content) ?? $content;
        $markers = array_map(static fn (array $letter): string => implode('', $letter), $letters);
        $rows = [];

        foreach ($letters as $index => [$letter, $name, $tree]) {
            $marker = $markers[$index];
            $start = mb_strpos($flat, $marker);
            if ($start === false) {
                continue;
            }
            $bodyStart = $start + mb_strlen($marker);
            $nextMarker = $markers[$index + 1] ?? null;
            $end = $nextMarker === null ? mb_strlen($flat) : mb_strpos($flat, $nextMarker, $bodyStart);
            $meaning = trim(mb_substr($flat, $bodyStart, ($end === false ? mb_strlen($flat) : $end) - $bodyStart));
            $meaning = preg_replace('/^(?:Premier|Deuxième|Troisième|Quatrième) Aicme — Les Arbres de [^:]+ :/u', '', $meaning) ?? $meaning;
            $meaning = preg_replace('/(?:Deuxième|Troisième|Quatrième) Aicme\b.*$/u', '', $meaning) ?? $meaning;
            $meaning = preg_replace('/Lettre\s*Nom\s*Arbre\s*Signification.*$/ui', '', $meaning) ?? $meaning;
            $rows[] = ['letter' => $letter, 'name' => $name, 'tree' => $tree, 'meaning' => trim($meaning), 'anchor' => $this->anchor('ogham', $name)];
        }

        return $rows;
    }

    /** @param list<string> $labels @return list<array{label: string, value: string}> */
    private function extractArrowItems(string $content, array $labels): array
    {
        $flat = preg_replace('/\s+/u', ' ', $content) ?? $content;
        $items = [];
        foreach ($labels as $index => $label) {
            $start = mb_strpos($flat, $label.' →');
            if ($start === false) {
                continue;
            }
            $valueStart = $start + mb_strlen($label.' →');
            $next = $labels[$index + 1] ?? null;
            $end = $next === null ? mb_strlen($flat) : mb_strpos($flat, $next.' →', $valueStart);
            $items[] = ['label' => $label, 'value' => trim(mb_substr($flat, $valueStart, ($end === false ? mb_strlen($flat) : $end) - $valueStart))];
        }

        return $items;
    }

    /** @param list<string> $labels @return list<array{label: string, value: string}> */
    private function extractDashItems(string $content, array $labels): array
    {
        $flat = preg_replace('/\s+/u', ' ', $content) ?? $content;
        $items = [];
        foreach ($labels as $index => $label) {
            $start = mb_strpos($flat, $label.' —');
            if ($start === false) {
                continue;
            }
            $valueStart = $start + mb_strlen($label.' —');
            $next = $labels[$index + 1] ?? null;
            $end = $next === null ? mb_strlen($flat) : mb_strpos($flat, $next.' —', $valueStart);
            $items[] = ['label' => $label, 'value' => trim(mb_substr($flat, $valueStart, ($end === false ? mb_strlen($flat) : $end) - $valueStart))];
        }

        return $items;
    }

    /** @param list<string> $themes @return list<array{title: string, anchor: string, items: list<array{title: string, anchor: string}>}> */
    private function extractWisdom(string $content, array $themes): array
    {
        $groups = [];
        foreach ($themes as $index => $theme) {
            $start = mb_strpos($content, $theme);
            if ($start === false) {
                continue;
            }
            $bodyStart = $start + mb_strlen($theme);
            $next = $themes[$index + 1] ?? null;
            $end = $next === null ? mb_strlen($content) : mb_strpos($content, $next, $bodyStart);
            $body = trim(mb_substr($content, $bodyStart, ($end === false ? mb_strlen($content) : $end) - $bodyStart));
            preg_match_all('/^\d+\.\s+(.+)$/mu', $body, $matches);
            $items = [];
            foreach (array_map('trim', $matches[1] ?? []) as $itemIndex => $wisdom) {
                $items[] = ['title' => $wisdom, 'anchor' => sprintf('sagesse-%s-%d', $this->slug($theme), $itemIndex + 1)];
            }
            $groups[] = ['title' => $theme, 'anchor' => $this->anchor('sagesses', $theme), 'items' => $items];
        }

        return $groups;
    }

    /** @param list<array{label: string, value: string}> $items @return list<array{label: string, value: string, anchor: string}> */
    private function withAnchors(array $items, string $prefix): array
    {
        return array_map(fn (array $item): array => $item + ['anchor' => $this->anchor($prefix, $item['label'])], $items);
    }

    private function anchor(string $prefix, string $label): string
    {
        return $prefix.'-'.$this->slug($label);
    }

    private function slug(string $label): string
    {
        return (new AsciiSlugger())->slug($label)->lower()->toString();
    }
}
