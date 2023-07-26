<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Provider\Iterator;

class PokemonListRestIterator extends AbstractRestIterator
{
    protected function getRowsFromPageData(array $data): array
    {
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'name' => $item['name'],
                'code' => $item['url'],
            ];
        }

        return $rows;
    }

    protected function getResource(): string
    {
        return 'pokemon';
    }
}
