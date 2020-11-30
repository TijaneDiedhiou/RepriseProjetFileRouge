<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 * * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *         "get_grpecompetences"={
 *              "security"="(is_granted('ROLE_FORMATEUR'))",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *              "method"="GET", 
 *              "path"="/admin/grpecompetences"
 *          },
 *          "get_competences"={
 *              "security"="(is_granted('ROLE_ADMIN'))",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/competences",
 *              "normailzation_context"={"groups"={"groupecompetence:read", "competences:read"}}
 *          },
 *          "add_grpecompetence"={
 *              "method"="POST",
 *              "path"="/admin/grpecompetences" 
 *          }

 *      },
 *      itemOperations={
 *          "get_grpecompetence"={
 *              "security"="(is_granted('VIEW', object))",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *              "method"="GET", "path"="/admin/grpecompetences/{id}"
 *          },
 *      }
 * )
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences")
     */
    private $competence;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }
}
