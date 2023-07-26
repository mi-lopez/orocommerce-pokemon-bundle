<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Symfony\Component\HttpFoundation\ParameterBag;
use Synolia\Bundle\PokemonBundle\Constant\PokemonConstant;

/**
 * @ORM\Entity
 * @Config()
 */
class PokemonTransportSettings extends Transport
{
    /** @var ParameterBag */
    protected $settings;

    /**
     * @ORM\Column(name="synolia_pokemon_url", type="string", length=255, nullable=false)
     */
    protected string $url;

    public function getSettingsBag(): ParameterBag
    {
        if (null === $this->settings) {
            $this->settings = new ParameterBag(
                [
                    PokemonConstant::URL => $this->getUrl(),
                ]
            );
        }

        return $this->settings;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
