<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('image_url', [$this, 'generateImageUrl']),
        ];
    }

    public function generateImageUrl(?string $imagePath): string
    {
        $baseUrl = 'https://media.themoviedb.org/t/p/w220_and_h330_face';

        return $baseUrl . $imagePath;
    }
}