<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\Migration\OroOptions;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * Creates all tables required for the bundle.
 */
class SynoliaPokemonInstaller implements Installation
{
    public function getMigrationVersion()
    {
        return 'v1_1';
    }

    public function up(Schema $schema, QueryBag $queries): void
    {
        $this->createSynoliaPokemonPokemonTable($schema);
        $this->addSynoliaPokemonPokemonForeignKeys($schema);
        $this->addSynoliaPokemonSettingsTable($schema);
    }

    private function createSynoliaPokemonPokemonTable(Schema $schema): void
    {
        $table = $schema->createTable('synolia_pokemon_pokemon');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('code', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('image', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('type', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('created_at', 'datetime', [OroOptions::KEY => ['importexport' => ['excluded' => true]]]);
        $table->addColumn('updated_at', 'datetime', [OroOptions::KEY => ['importexport' => ['excluded' => true]]]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }

    private function addSynoliaPokemonPokemonForeignKeys(Schema $schema): void
    {
        $table = $schema->getTable('synolia_pokemon_pokemon');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    private function addSynoliaPokemonSettingsTable(Schema $schema): void
    {
        $table = $schema->getTable('oro_integration_transport');
        $table->addColumn('synolia_pokemon_url', 'string', ['notnull' => false, 'length' => 255]);
    }
}
