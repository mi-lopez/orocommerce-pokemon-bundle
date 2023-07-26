<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synolia\Bundle\PokemonBundle\Constant\PokemonConstant;
use Synolia\Bundle\PokemonBundle\Entity\PokemonTransportSettings;

class PokemonTransportSettingsType extends AbstractType
{
    public const NAME = 'synolia_pokemon_transport_settings_type';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            PokemonConstant::URL,
            UrlType::class,
            [
                'label' => 'synolia.pokemon.form.transport.url.label',
                'required' => true,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PokemonTransportSettings::class,
        ]);
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix(): string
    {
        return self::NAME;
    }
}
