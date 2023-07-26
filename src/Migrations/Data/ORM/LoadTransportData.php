<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\MigrationBundle\Fixture\VersionedFixtureInterface;
use Oro\Bundle\UserBundle\DataFixtures\UserUtilityTrait;
use Oro\Bundle\UserBundle\Migrations\Data\ORM\LoadAdminUserData;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Synolia\Bundle\PokemonBundle\Constant\PokemonConstant;
use Synolia\Bundle\PokemonBundle\Entity\PokemonTransportSettings;
use Synolia\Bundle\PokemonBundle\Trait\OrganizationManagerTrait;

final class LoadTransportData extends AbstractFixture implements
    DependentFixtureInterface,
    VersionedFixtureInterface,
    ContainerAwareInterface
{
    use ContainerAwareTrait;
    use OrganizationManagerTrait;
    use UserUtilityTrait;

    protected const URL = 'https://pokeapi.co/api/v2/';

    public function getDependencies(): array
    {
        return [
            LoadAdminUserData::class,
        ];
    }

    public function getVersion(): string
    {
        return 'v1_0';
    }

    public function load(ObjectManager $manager): void
    {
        $transport = new PokemonTransportSettings();
        foreach ($this->getTransportData() as $property => $value) {
            PropertyAccess::createPropertyAccessor()->setValue($transport, $property, $value);
        }
        $manager->persist($transport);
        $this->setReference('synolia_pokemon:transport', $transport);
        $manager->flush();
    }

    public function getTransportData(): array
    {
        return [
            PokemonConstant::URL => self::URL,
        ];
    }
}
