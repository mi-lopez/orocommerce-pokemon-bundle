<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddPokemonTransportSettings implements Migration
{
    public function up(Schema $schema, QueryBag $queries): void
    {
        $table = $schema->getTable('oro_integration_transport');

        $table->addColumn('synolia_pokemon_url', 'string', ['notnull' => false, 'length' => 255]);
    }
}
