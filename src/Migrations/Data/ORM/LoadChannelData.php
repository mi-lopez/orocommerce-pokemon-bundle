<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\MigrationBundle\Fixture\VersionedFixtureInterface;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\DataFixtures\UserUtilityTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Synolia\Bundle\PokemonBundle\Constant\PokemonConstant;
use Synolia\Bundle\PokemonBundle\Entity\PokemonTransportSettings;
use Synolia\Bundle\PokemonBundle\Provider\ChannelType;
use Synolia\Bundle\PokemonBundle\Trait\OrganizationManagerTrait;

final class LoadChannelData extends AbstractFixture implements
    DependentFixtureInterface,
    VersionedFixtureInterface,
    ContainerAwareInterface
{
    use ContainerAwareTrait;
    use OrganizationManagerTrait;
    use UserUtilityTrait;

    public function getDependencies(): array
    {
        return [
            LoadTransportData::class,
        ];
    }

    public function getVersion(): string
    {
        return 'v1_0';
    }

    public function load(ObjectManager $manager): void
    {
        /** @var Organization $organization */
        $organization = $this->getOrganization($manager);

        $channel = new Channel();
        /** @var PokemonTransportSettings $transport */
        $transport = $this->getReference('synolia_pokemon:transport');
        $channel
            ->setType(ChannelType::TYPE)
            ->setName(PokemonConstant::CHANNEL_NAME)
            ->setEnabled(true)
            ->setOrganization($organization)
            ->setDefaultUserOwner($this->getFirstUser($manager))
            ->setTransport($transport);

        $manager->persist($channel);
        $manager->flush();
    }
}
