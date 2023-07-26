<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Provider\Connector;

use Oro\Bundle\IntegrationBundle\Provider\AbstractConnector;
use Oro\Bundle\IntegrationBundle\Provider\ConnectorInterface;
use Synolia\Bundle\PokemonBundle\Entity\Pokemon;
use Synolia\Bundle\PokemonBundle\Provider\Iterator\PokemonListRestIterator;
use Synolia\Bundle\PokemonBundle\Provider\PokemonTransport;

/**
 * @property PokemonTransport $transport
 */
class PokemonListConnector extends AbstractConnector implements ConnectorInterface
{
    public function getLabel(): string
    {
        return 'synolia.pokemon.connector.pokemon_list.label';
    }

    public function getImportEntityFQCN(): string
    {
        return Pokemon::class;
    }

    public function getImportJobName(): string
    {
        return 'pokemon_list_data_import';
    }

    public function getType(): string
    {
        return 'pokemon';
    }

    protected function getConnectorSource(): PokemonListRestIterator
    {
        return $this->transport->getPokemonList();
    }
}
