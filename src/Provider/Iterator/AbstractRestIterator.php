<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Provider\Iterator;

use Oro\Bundle\IntegrationBundle\Provider\Rest\Client\AbstractRestIterator as BaseAbstractRestIterator;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Client\RestClientInterface;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Exception\RestException;

abstract class AbstractRestIterator extends BaseAbstractRestIterator
{
    protected const OFFSET = 0;
    protected const LIMIT = 20;

    protected ?string $nextPageUrl = null;

    abstract protected function getResource(): string;

    /**
     * @throws RestException
     */
    protected function loadPage(RestClientInterface $client): array
    {
        $data = [];

        if (!$this->firstLoaded) {
            $data = $client->getJSON($this->getResource(), $this->getParams());
        } elseif ($this->nextPageUrl) {
            $data = $this->client->getJSON($this->nextPageUrl);
        }

        if (isset($data['next'])) {
            $this->nextPageUrl = (string) $data['next'];
        } else {
            $this->nextPageUrl = null;
        }

        if (isset($data['results'])) {
            return $data['results'];
        }

        return [];
    }

    protected function getTotalCountFromPageData(array $data, $previousValue): ?int
    {
        if (isset($data['count'])) {
            return (int) $data['count'];
        }

        return $previousValue;
    }

    protected function getParams(): array
    {
        return ['offset' => self::OFFSET, 'limit' => self::LIMIT];
    }
}
