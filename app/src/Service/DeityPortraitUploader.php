<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class DeityPortraitUploader
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/dieux')]
        private readonly string $targetDirectory,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = strtolower($this->slugger->slug($originalName)->toString()) ?: 'portrait-divin';
        $extension = $file->guessExtension() ?: 'bin';
        $filename = sprintf('%s-%s.%s', $safeName, bin2hex(random_bytes(6)), $extension);

        $file->move($this->targetDirectory, $filename);

        return $filename;
    }
}
