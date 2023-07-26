<?php

namespace Synolia\Bundle\PokemonBundle\Controller\Frontend;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Synolia\Bundle\PokemonBundle\Entity\Pokemon;

class PokemonAjaxController extends AbstractController
{
    public function __construct(protected ManagerRegistry $doctrine)
    {
    }

    /**
     * @Route(
     *     "/get-images",
     *     name="synolia_pokemon_get_images",
     *     methods={"GET"},
     *     options={"expose"=true}
     * )
     */
    public function getPokemonImagesAction()
    {
        $images = $this->doctrine->getRepository(Pokemon::class)->getImages();

        if (empty($images)) {
            return new JsonResponse(['success' => false, 'message' => 'Not enough Pokemons to start the game']);
        } else {
            return new JsonResponse(['success' => true, 'images' => $images]);
        }
    }
}
