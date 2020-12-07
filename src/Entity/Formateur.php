<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *       normalizationContext={"groups"={"user:read"}},
 *      collectionOperations={
 *          "get_formateurs"={
 *              "method"="GET",
 *              "path"="/formateurs",
 *              "security"="(is_granted('ROLE_FORMATEUR','ROLE_CM'))",
 *              "security_message"= "Vous n'avez pas acces à cette ressource"
 *          },
 *      },
 *      itemOperations={
 *          "get_formateur"={
 *              "normalization_context"={"groups"={"user:read","user:read:all"}},
 *              "method"="GET",
 *              "path"="/formateurs/{id}",
 *              "security"="is_granted('ROLE_CM')",
 *              "security_message"= "Vous n'avez pas acces à cette ressource",
 *          },
 *      }
 * )
 */
class Formateur extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promos::class, mappedBy="formateur")
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="formateur")
     */
    private $groupes;

   

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promos[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promos $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addFormateur($this);
        }

        return $this;
    }

    public function removePromo(Promos $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeFormateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeFormateur($this);
        }

        return $this;
    }

   
}
