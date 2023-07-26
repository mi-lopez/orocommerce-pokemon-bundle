<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Provider;

use Oro\Bundle\IntegrationBundle\Provider\Rest\Transport\AbstractRestTransport;
use Symfony\Component\HttpFoundation\ParameterBag;
use Synolia\Bundle\PokemonBundle\Entity\PokemonTransportSettings;
use Synolia\Bundle\PokemonBundle\Form\Type\PokemonTransportSettingsType;
use Synolia\Bundle\PokemonBundle\Provider\Iterator\PokemonListRestIterator;

class PokemonTransport extends AbstractRestTransport
{
    public function getLabel(): string
    {
        return 'synolia.pokemon.transport.label';
    }

    public function getSettingsFormType(): string
    {
        return PokemonTransportSettingsType::class;
    }

    public function getSettingsEntityFQCN(): string
    {
        return PokemonTransportSettings::class;
    }

    public function getPokemonList(): PokemonListRestIterator
    {
        return new PokemonListRestIterator($this->getClient());
    }

    protected function getClientBaseUrl(ParameterBag $parameterBag): string
    {
        return rtrim($parameterBag->get('url'), '/') . '/';
    }

    protected function getClientOptions(ParameterBag $parameterBag): array
    {
        return [];
    }
}
