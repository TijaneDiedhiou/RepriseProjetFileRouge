<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 *  * @ApiResource(
 *    routePrefix="/admin",
 *    collectionOperations={
 *          "get_promoApprenant"={
 *              "method"="GET",
 *              "path"="/groupes",
 *               },
 *          "get_apprenant"={
 *              "method"="GET",
 *              "path"="/groupes/apprenants",
 *          }, 
 *          "post_apprenantFormateur"={
 *              "method"="POST",
 *              "path"="/groupes",
 *              "denormalization_context"={"groups"={"POSTgroupe:read"}},
 *          }
 *      },
 *      itemOperations={
 *          "get_user"={
 *               "method"="GET",
 *               "path"="/groupes/{id}",
 *                },
 *           "update"={
 *                 "method"="PUT",
 *                 "path"="/users/{id}",
 *                  },
 *      "DELETE"
 * }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Promos::class, inversedBy="groupes")
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes",cascade={"persist"})
     * @Groups("POSTgroupe:read")
     * 
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes",cascade={"persist"})
     * @Groups("POSTgroupe:read")
     * 
     */
    private $apprenant;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPromos(): ?Promos
    {
        return $this->promos;
    }

    public function setPromos(?Promos $promos): self
    {
        $this->promos = $promos;

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenant->removeElement($apprenant);

        return $this;
    }
}
