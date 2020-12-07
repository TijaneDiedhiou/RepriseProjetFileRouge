<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("PostCompetence:read")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("groupeCompetence:read")
     * @Groups({"PostCompetence:read","GetCompetence:read"})
     * @Groups("AfficherLesGrpCompreferentiel:read")
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupeCompetence:read","GetCompetence:read","PostCompetence:read"})
     * @Groups("AfficherLesGrpCompreferentiel:read")
     * 
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="niveaux")
     * 
     */
    private $competence;

    /**
     * @ORM\Column(type="text")
     * @Groups({"groupeCompetence:read","GetCompetence:read","PostCompetence:read"})
     * @Groups("AfficherLesGrpCompreferentiel:read")
     */
    private $groupeAction;

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

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

        return $this;
    }
}
