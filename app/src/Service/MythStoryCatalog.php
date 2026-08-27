<?php

namespace App\Service;

use App\Repository\DieuRepository;
use JsonException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class MythStoryCatalog
{
    private ?array $stories = null;

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        private readonly DieuRepository $dieuRepository,
    ) {
    }

    /**
     * @return list<array{slug: string, title: string, eyebrow: string, summary: string, content: list<string>, image: ?string, imageAlt: string}>
     */
    public function all(): array
    {
        if ($this->stories !== null) {
            return $this->stories;
        }

        $contents = file_get_contents($this->projectDir.'/data/myth_stories.json');
        if ($contents === false) {
            throw new RuntimeException('Le catalogue des récits mythologiques est introuvable.');
        }

        try {
            $stories = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Le catalogue des récits mythologiques est invalide.', previous: $exception);
        }

        if (!is_array($stories)) {
            throw new RuntimeException('Le catalogue des récits mythologiques est invalide.');
        }

        $portraits = [];
        $slugger = new AsciiSlugger();
        foreach ($this->dieuRepository->findAll() as $dieu) {
            if ($dieu->getName() !== null && $dieu->getImg() !== null) {
                $portraits[$this->normalizeName($dieu->getName(), $slugger)] = $dieu->getImg();
            }
        }

        $aliases = [
            'angus' => 'aengus-og',
            'grannus' => 'apollo-grannus',
            'the-morrigan' => 'morrigan',
        ];

        $storyPortraits = [
            'endovelicus' => 'images/dieux/mythes/endovelicus.png',
            'ataegina' => 'images/dieux/mythes/ataegina.png',
            'bandua' => 'images/dieux/mythes/bandua.png',
            'reue' => 'images/dieux/mythes/reue.png',
            'trebaruna' => 'images/dieux/mythes/trebaruna.png',
            'nabia' => 'images/dieux/mythes/nabia.png',
            'cossus' => 'images/dieux/mythes/cossus.png',
            'lugus' => 'images/dieux/mythes/lugus.png',
        ];

        foreach ($stories as &$story) {
            $normalizedName = $this->normalizeName($story['title'], $slugger);
            $portraitKey = $aliases[$normalizedName] ?? $normalizedName;

            $story['image'] = null;
            $story['imageAlt'] = 'Portrait de '.$story['title'];

            if ($normalizedName === 'dagda') {
                $story['image'] = 'images/dieux/dagda-portrait.png';
            } elseif (isset($storyPortraits[$normalizedName])) {
                $story['image'] = $storyPortraits[$normalizedName];
            } elseif (isset($portraits[$portraitKey])) {
                $story['image'] = 'uploads/dieux/'.$portraits[$portraitKey];
            }
        }
        unset($story);

        return $this->stories = $stories;
    }

    /**
     * @return array{slug: string, title: string, eyebrow: string, summary: string, content: list<string>, image: ?string, imageAlt: string}|null
     */
    public function find(string $slug): ?array
    {
        foreach ($this->all() as $story) {
            if ($story['slug'] === $slug) {
                return $story;
            }
        }

        return null;
    }

    private function normalizeName(string $name, AsciiSlugger $slugger): string
    {
        $name = preg_replace('/\s*\([^)]*\)\s*/u', '', $name) ?? $name;

        return strtolower($slugger->slug(trim($name))->toString());
    }
}
