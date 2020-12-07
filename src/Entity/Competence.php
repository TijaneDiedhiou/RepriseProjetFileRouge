<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 * @ApiResource(
 *      collectionOperations={
 *          "get_competences"={
 *              "method"="GET",
 *              "path"="admin/competences",
 *              "normalization_context"={"groups"={"GetCompetence:read"}}
 *          },
 *          "add_Competence"={
 *              "method"="POST",
 *              "path"="admin/competences",
 *              "denormalization_context"={"groups"={"PostCompetence:read"}}
 * }
 *      },
 *        itemOperations={
 *          "get_competence"={
 *              "method"="GET",
 *              "path"="admin/competences/{id}",
 *              "normalization_context"={"groups"={"GetCompetence:read"}}
 *          },
 *          "UpdateCompetence"={
 *              "method"="PUT",
 *              "path"="admin/competences/{id}",
 *              "denormalization_context"={"groups"={"PostCompetence:read"}}
 *              },
 *          "DELETE"
 *      }
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GetCompetence:read",
     * "PostCompetence:read",
     * "GetgroupeCompetence:read",
     * "GetgroupeCompetenceid:read",
     * "PostgroupeCompetence:read"})
     * @Assert\NotBlank(message="le libbelle ne peut pas etre vide")
     * 
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competence",cascade={"persist"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence",cascade={"persist"})
     * @Groups({"GetCompetence:read",
     * "PostCompetence:read",
     * "AfficherLesGrpCompreferentiel:read",
     * "groupeCompetence:read"})
     * @Assert\Count(
     *      min = 3,
     *      max = 3,
     *      minMessage = "You must specify at least one email",
     *      maxMessage = "You cannot specify more than {{ limit }} emails"
     * )
     */
    private $niveaux;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupeCompetence:read",
     * "Referentiel:read",
     * "GetCompetence:read",
     * "PostCompetence:read",
     * "GetgroupeCompetenceid:read",
     * "PostgroupeCompetence:read"
     * })
     * @Assert\NotBlank(message="le descriptif ne peut pas etre vide")
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"GetCompetence:read","GetgroupeCompetenceid:read"})
     * @Groups("PostCompetence:read")
     * 
     * 
     */
    private $isDeleted = false;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

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
