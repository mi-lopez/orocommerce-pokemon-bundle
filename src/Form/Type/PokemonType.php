<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synolia\Bundle\PokemonBundle\Entity\Pokemon;

/**
 * Form type for Pokemon entity.
 */
class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'code',
                TextType::class,
                ['label' => 'synolia.pokemon.code.label', 'required' => false]
            )
            ->add(
                'name',
                TextType::class,
                ['label' => 'synolia.pokemon.name.label', 'required' => false]
            )
            ->add(
                'image',
                TextType::class,
                ['label' => 'synolia.pokemon.image.label', 'required' => false]
            )
            ->add(
                'type',
                TextType::class,
                ['label' => 'synolia.pokemon.type.label', 'required' => false]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
