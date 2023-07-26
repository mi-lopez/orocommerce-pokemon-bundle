<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Controller;

use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Synolia\Bundle\PokemonBundle\Entity\Pokemon;
use Synolia\Bundle\PokemonBundle\Form\Type\PokemonType;

/**
 * Contains CRUD actions for Pokemon
 *
 * @Route("/", name="synolia_pokemon_pokemon_")
 */
class PokemonController extends AbstractController
{
    public function __construct(
        protected TranslatorInterface $translator,
        protected UpdateHandlerFacade $updateHandlerFacade
    ) {
    }

    /**
     * @Route("/", name="index")
     *
     * @Template
     *
     * @AclAncestor("synolia_pokemon_pokemon_view")
     */
    public function indexAction(): array
    {
        return [
            'entity_class' => Pokemon::class,
        ];
    }

    /**
     * @Route("/view/{id}", name="view", requirements={"id"="\d+"})
     *
     * @Template
     *
     * @Acl(
     *      id="synolia_pokemon_pokemon_view",
     *      type="entity",
     *      class="Synolia\Bundle\PokemonBundle\Entity\Pokemon",
     *      permission="VIEW"
     * )
     */
    public function viewAction(Pokemon $entity): array
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * Create Pokemon
     *
     * @Route("/create", name="create", options={"expose"=true})
     *
     * @Template("@SynoliaPokemon/Pokemon/update.html.twig")
     *
     * @Acl(
     *      id="synolia_pokemon_pokemon_create",
     *      type="entity",
     *      class="Synolia\Bundle\PokemonBundle\Entity\Pokemon",
     *      permission="CREATE"
     * )
     */
    public function createAction(Request $request): array|RedirectResponse
    {
        $createMessage = $this->translator->trans(
            'synolia.pokemon.controller.pokemon.saved.message'
        );

        return $this->update(new Pokemon(), $request, $createMessage);
    }

    /**
     * Edit Pokemon form
     *
     * @Route("/update/{id}", name="update", requirements={"id"="\d+"})
     *
     * @Template
     *
     * @Acl(
     *      id="synolia_pokemon_pokemon_update",
     *      type="entity",
     *      class="Synolia\Bundle\PokemonBundle\Entity\Pokemon",
     *      permission="EDIT"
     * )
     */
    public function updateAction(Pokemon $entity, Request $request): array|RedirectResponse
    {
        $updateMessage = $this->translator->trans(
            'synolia.pokemon.controller.pokemon.saved.message'
        );

        return $this->update($entity, $request, $updateMessage);
    }

    protected function update(
        Pokemon $entity,
        Request $request,
        string $message = ''
    ): array|RedirectResponse {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->createForm(PokemonType::class, $entity),
            $message,
            $request,
            null
        );
    }
}
