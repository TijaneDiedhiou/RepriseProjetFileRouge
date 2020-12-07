<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 *  @ApiResource(
 *     normalizationContext={"groups"={"profil:read"}},
 *     routePrefix="/admin",
 *     attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"= "Vous n'avez pas acces à cette ressource"
 *     },
 *     collectionOperations={
 *          "GET","POST"
 *       },
 *      itemOperations={
 *          "get_profil"={
 *              "method"="GET",
 *              "path"="/profils/{id}",
 *              "requirements"={"id"="\d+"}
 *          },
 *          "update_profil"={
 *              "method"="PUT",
 *              "path"="/profils/{id}",
 *              "requirements"={"id"="\d+"}
 *          },
 *          "get_profil_users"={
 *              "method"="GET",
 *              "path"="/profils/{id }/users",
 *              "requirements"={"id"="\d+"},
 *              "defaults" = {"id"=null},
 *              "normalization_context"={"groups"={"profil:read","profil:read:all"}}
 *          },
 *          "delete_profil"={
 *              "method"="DELETE",
 *              "path"="/profils/{id}",
 *              "requirements"={"id"="\d+"}
 *          }
 *      }
 * )
 * @UniqueEntity(
 *      fields={"libelle"},
 *      message="Ce libellé existe déjà"
 * )

 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("profil:read")

     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @ApiSubresource()
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("profil:read")
     * @Assert\NotBlank(message="Veuillez renseigné les Champ ")
     * 
     */
    protected $libelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("profil:read")
     */
    protected $isDeleted = false;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }


    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}

