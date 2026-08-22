<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class AvatarUploader
{
    private const MAX_SIZE = 2_000_000;

    /** @var array<string, string> */
    private const EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    public function __construct(
        #[Autowire('%kernel.project_dir%/public/uploads/avatars')]
        private readonly string $targetDirectory,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        if (!$file->isValid() || $file->getSize() === false || $file->getSize() > self::MAX_SIZE) {
            throw new \InvalidArgumentException('L’avatar doit être une image de 2 Mo maximum.');
        }

        $imageInfo = @getimagesize($file->getPathname());
        $mimeType = is_array($imageInfo) ? ($imageInfo['mime'] ?? null) : null;
        if (!is_string($mimeType) || !isset(self::EXTENSIONS[$mimeType])) {
            throw new \InvalidArgumentException('Choisis une image JPEG, PNG ou WebP valide.');
        }

        if (!is_dir($this->targetDirectory) && !mkdir($this->targetDirectory, 0775, true) && !is_dir($this->targetDirectory)) {
            throw new \RuntimeException('Le Sanctuaire ne peut pas enregistrer cet avatar pour le moment.');
        }

        $filename = bin2hex(random_bytes(20)).'.'.self::EXTENSIONS[$mimeType];
        $file->move($this->targetDirectory, $filename);

        return $filename;
    }
}
