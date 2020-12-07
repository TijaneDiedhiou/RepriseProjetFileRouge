<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "get_referentiels"={
 *              "method"="GET",
 *              "path"="admin/referentiels",
*              "normalization_context"={"groups"={"AfficherReferentiel:read"}}
 *              
*          },
*          "get_referentiels_grpcompetences"={
*              "method"="GET",
*              "path"="/admin/referentiels/grpecompetences",
*              "normalization_context"={"groups"={"AfficherLesGrpCompreferentiel:read",}}
*              
*          },
 *          "AddReferentiel"={
 *              "method"="POST",
 *              "path"="admin/referentiels",
*              "denormalization_context"={"groups"={"Referentiel:read"}}
 * 
 *          }
 *      },
 *      itemOperations={
 *          "get_referentiel"={
 *              "method"="GET",
 *              "path"="admin/referentiels/{id}",
*              "normalization_context"={"groups"={"AfficherReferentiel:read"}}
 * 
 *          },
 *          "get_referentiel_grpecompetence_competences"={
 *              "method"="GET",
 *              "path"="admin/referentiels/{id}/grpecompetences/{idg}/competences"
 *              
 *          },
 *          "update_referentiel"={
 *              "method"="PUT",
 *              "path"="admin/referentiels/{id}",
 *              
 *          }
 *      }
 * )
 */

class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("AfficherReferentiel:read")
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups("AfficherReferentiel:read")
     */
    private $presentation;

    /**
     * @ORM\Column(type="text")
     * @Groups("AfficherReferentiel:read")
     * 
     * 
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="text")
     * @Groups("AfficherReferentiel:read")
     * 
     * 
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels",cascade={"persist"})
     * @Groups("AfficherLesGrpCompreferentiel:read")
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Promos::class, mappedBy="referentiel")
     */
    private $promos;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $programme;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDeleted;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

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
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetences->removeElement($groupeCompetence);

        return $this;
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
            $promo->addReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promos $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeReferentiel($this);
        }

        return $this;
    }

    public function getProgramme()
    {
        return $this->programme;
    }

    public function setProgramme($programme): self
    {
        if ($this->programme)
         {
            $data = stream_get_contents($this->programme);
             if (!$this->programme){
                fclose($this->programme);
             }
             return base64_encode($data );
        }else {
            return null;
        }

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
