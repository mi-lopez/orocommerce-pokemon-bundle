<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PokemonTypeBadgeExtension extends AbstractExtension
{
    private const TYPES = [
        'grass' => 'success',
        'fire' => 'danger',
        'water' => 'info',
        'bug' => 'success',
        'electric' => 'warning',
        'poison' => 'dark',
        'normal' => '',
    ];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_type_badge', [$this, 'getTypeBadge']),
        ];
    }

    public function getTypeBadge(?string $type): string
    {
        return self::TYPES[$type] ?? '';
    }
}
