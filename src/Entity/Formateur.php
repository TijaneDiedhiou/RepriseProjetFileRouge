<?php

namespace App\Entity;

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

    public function getId(): ?int
    {
        return $this->id;
    }
}
