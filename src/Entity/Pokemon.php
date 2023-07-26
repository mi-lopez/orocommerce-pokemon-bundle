<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;
use Oro\Bundle\LocaleBundle\Model\NameInterface;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationAwareInterface;
use Oro\Bundle\UserBundle\Entity\Ownership\AuditableUserAwareTrait;

/**
 * ORM Entity Pokemon.
 *
 * @ORM\Entity(
 *     repositoryClass="Synolia\Bundle\PokemonBundle\Entity\Repository\PokemonRepository"
 * )
 * @ORM\Table(
 *     name="synolia_pokemon_pokemon"
 * )
 * @Config(
 *     routeName="synolia_pokemon_pokemon_index",
 *     routeView="synolia_pokemon_pokemon_view",
 *     routeCreate="synolia_pokemon_pokemon_create",
 *     routeUpdate="synolia_pokemon_pokemon_update",
 *     defaultValues={
 *         "form"={
 *             "form_type"="Synolia\Bundle\PokemonBundle\Form\Type\PokemonCreateOrSelectType",
 *             "grid_name"="synolia-pokemon-pokemon-grid-select"
 *         },
 *         "grid"={
 *             "default"="synolia-pokemon-pokemon-grid-select"
 *         },
 *         "entity"={
 *             "icon"="fa-question"
 *         },
 *         "ownership"={
 *             "owner_type"="USER",
 *             "owner_field_name"="owner",
 *             "owner_column_name"="user_owner_id",
 *             "organization_field_name"="organization",
 *             "organization_column_name"="organization_id"
 *         },
 *         "security"={
 *             "type"="ACL",
 *             "group_name"="",
 *             "category"=""
 *         },
 *         "dataaudit"={
 *             "auditable"=false
 *         }
 *     }
 * )
 */
class Pokemon implements
    ExtendEntityInterface,
    DatesAwareInterface,
    OrganizationAwareInterface,
    NameInterface
{
    use AuditableUserAwareTrait;
    use DatesAwareTrait;
    use ExtendEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="code",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     * @ConfigField(
     *     defaultValues={
     *         "dataaudit"={
     *             "auditable"=false
     *         },
     *         "importexport"={
     *             "identity"=true
     *         }
     *     }
     * )
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     * @ConfigField(
     *     defaultValues={
     *         "dataaudit"={
     *             "auditable"=false
     *         }
     *     }
     * )
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="image",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     * @ConfigField(
     *     defaultValues={
     *         "dataaudit"={
     *             "auditable"=false
     *         }
     *     }
     * )
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="type",
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     * @ConfigField(
     *     defaultValues={
     *         "dataaudit"={
     *             "auditable"=false
     *         }
     *     }
     * )
     */
    protected $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
