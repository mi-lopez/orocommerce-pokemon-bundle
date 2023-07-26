<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\ImportExport\Strategy;

use Oro\Bundle\ImportExportBundle\Strategy\Import\ConfigurableAddOrReplaceStrategy;

class ConfigurableAddOrUpdateStrategy extends ConfigurableAddOrReplaceStrategy
{
    /**
     * The AbstractSyncProcessor expects UpdateCount and not ReplaceCount to do the report
     *
     * @param mixed $entity
     */
    protected function updateContextCounters($entity): void
    {
        $identifier = $this->databaseHelper->getIdentifier($entity);
        if ($identifier || $this->newEntitiesHelper->getEntityUsage($this->getEntityHashKey($entity)) > 1) {
            $this->context->incrementReplaceCount();
            $this->context->incrementUpdateCount();
        } else {
            $this->context->incrementAddCount();
        }
    }
}
