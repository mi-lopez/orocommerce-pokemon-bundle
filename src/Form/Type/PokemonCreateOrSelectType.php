<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form type for Pokemon entity with inline create & select buttons
 */
class PokemonCreateOrSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'autocomplete_alias' => 'synolia_pokemon_pokemon',
                'create_form_route' => 'synolia_pokemon_pokemon_create',
                'grid_name' => 'synolia-pokemon-pokemon-grid-select',
            ]
        );
    }

    public function getParent()
    {
        return OroEntitySelectOrCreateInlineType::class;
    }
}
