<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
/**
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 * @ApiResource(
 *      collectionOperations={
 *         "get_grpecompetences"={
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *              "method"="GET", 
 *              "path"="/admin/grpecompetences",
 *              "normalization_context"={"groups"={"GetgroupeCompetence:read"}}
 *          },
 *          "add_grpecompetence"={
 *              "method"="POST",
 *              "path"="/admin/grpecompetences" ,
 *              "denormalization_context"={"groups"={"PostgroupeCompetence:read"}}
 *          },
 *          "getgrpecompetence"={
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/competences" ,
 *          },
 *      },
 *      itemOperations={
 *          "get_grpecompetence"={
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *              "method"="GET", 
 *              "path"="/admin/grpecompetences/{id}",
 *              "normalization_context"={"groups"={"GetgroupeCompetenceid:read"}}
 *          },
 *      "get_lesgrpecompetencegrp"={
 *              "method"="GET", 
 *              "path"="/admin/grpecompetences/{id}/competences",
 *              "normalization_context"={"groups"={"GetgroupeCompetence:read"}}
 *          },
 *          "update_grpecompetence"={
 *              "method"="PUT", 
 *              "path"="/admin/grpecompetences/{id}",
 *          },
 *      "DELETE"
 *      } 
 * )
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"PostCompetence:read","GetgroupeCompetence:read","PostgroupeCompetence:read"})
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"AfficherLesGrpCompreferentiel:read","GetgroupeCompetence:read","PostgroupeCompetence:read"})
     * @Assert\NotBlank(message="le libbelle ne peut pas etre vide")
     * 
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences",cascade={"persist"})
     * @Groups({"GetgroupeCompetence:read","GetgroupeCompetenceid:read","PostgroupeCompetence:read"})
     * @Assert\NotBlank(message="Veuillez renseigné le champ")
     * @Assert\NotBlank(message="le descriptif ne peut pas etre vide")
     * 
     * 
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetences")
     */
    private $referentiels;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("GetgroupeCompetence:read")
     * 
     */
    private $isDeleted = false;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

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
