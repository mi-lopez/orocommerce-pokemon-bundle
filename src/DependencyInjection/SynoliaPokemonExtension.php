<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SynoliaPokemonExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('repositories.yml');
        $loader->load('form_types.yml');
        $loader->load('controllers.yml');
        $loader->load('services.yml');
        $loader->load('connectors.yml');
        $loader->load('commands.yml');
    }
}
