<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Provider;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class ChannelType implements ChannelInterface, IconAwareIntegrationInterface
{
    public const TYPE = 'synolia_pokemon';

    public function getLabel(): string
    {
        return 'synolia.pokemon.channel_type.label';
    }

    public function getIcon(): string
    {
        return 'bundles/synoliapokemon/icon/pokemon.ico';
    }
}
