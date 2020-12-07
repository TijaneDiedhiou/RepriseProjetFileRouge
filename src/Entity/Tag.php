<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
 * collectionOperations={
 *          "get_grpstags"={
 *              "method"="GET",
 *              "path"="/admin/tags",
 *              "normalization_context"={"groups"={"getTag:read"}}
 *          },
 *          "add_gprstags"={
 *              "method"="POST",
 *              "path"="/admin/tags",
 *              "denormalization_context"={"groups"={"getTag:read"}},
 *          }    
 *      },
 *      itemOperations={
 *          "get_ungrpstags"={
 *               "method"="GET",
 *               "path"="/admin/tags/{id}",
 *               "normalization_context"={"groups"={"getTag:read"}}
 *          },
 *           
 *      "Update_TagsGroupeTags"={
 *                 "method"="PUT",
 *                 "path"="/admin/tags/{id}",
 *                 "denormalization_context"={"groups"={"getTag:read"}}
 *         },
 *      "DELETE"
 *      }
 * )
 * )
 * 
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Champs vide ")
     * @Groups({"getTag:read","postTag:read","getgroupeTag:read","postgroupeTag:read"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, inversedBy="tags",cascade={"persist"})
     * @Assert\NotBlank(message="Champs vide ")
     * @Groups({"getTag:read","postTag:read"})
     */
    private $groupeTag;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"getTag:read","postgroupeTag:read"})
     * 
     */
    private $isDeleted = false;

    public function __construct()
    {
        $this->groupeTag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTag(): Collection
    {
        return $this->groupeTag;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTag->contains($groupeTag)) {
            $this->groupeTag[] = $groupeTag;
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        $this->groupeTag->removeElement($groupeTag);

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
