<?php

namespace App\Entity;

use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 *  @ApiResource(
 *  collectionOperations={
 *          "get_grpstags"={
 *              "method"="GET",
 *              "path"="/admin/grptags",
 *              "normalization_context"={"groups"={"getgroupeTag:read"}}
 *          },
 *          "add_gprstags"={
 *              "method"="POST",
 *              "path"="/admin/grptags",
 *              "denormalization_context"={"groups"={"postgroupeTag:read"}}
 *          }    
 *      },
 *      itemOperations={
 *             "getgrpsidTag"={
 *                  "method"="GET",
 *                  "path"="/admin/grptags/{id}/tags"
 * },
 *            "Update_TagsGroupeTags"={
 *                 "method"="PUT",
 *                 "path"="/admin/grptags/{id}",
 *                "denormalization_context"={"groups"={"postgroupeTag:read"}},
 *         },
 *      "DELETE","GET"
 * }
 * )
 * )
 * 
 */
class GroupeTag
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
     * @Groups({"getTag:read","postTag:read","postgroupeTag:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"getTag:read","postgroupeTag:read"})
     * 
     */
    private $isDeleted;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupeTag",cascade={"persist"})
     * @Groups({"getgroupeTag:read","postgroupeTag:read"})
     * 
     */
    private $tags;

   
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupeTag($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupeTag($this);
        }

        return $this;
    }
}
