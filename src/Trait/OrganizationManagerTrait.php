<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Trait;

use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Entity\Organization;

trait OrganizationManagerTrait
{
    public function getOrganization(ObjectManager $manager): ?Organization
    {
        return $manager->getRepository(Organization::class)->findOneBy([]);
    }
}
