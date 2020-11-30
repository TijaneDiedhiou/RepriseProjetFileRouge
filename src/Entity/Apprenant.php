<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * * @ApiResource(
 *      collectionOperations={
 *          "get_apprenants"={
 *              "method"="GET",
 *              "path"="/apprenants",
 *              "security"="is_granted('ROLE_CM','ROLE_FORMATEUR')",
 *              "security_message"= "Vous n'avez pas acces à cette ressource"
 *          },
 *      },
 *      itemOperations={
 *          "get_apprenant"={
 *              "method"="GET",
 *              "path"="/apprenants/{id}"
 *          },
 *      }
 * )
 */
class Apprenant extends User
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
