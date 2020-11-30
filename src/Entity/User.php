<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="dtype", type="string")
 * @DiscriminatorMap({"admin" = "Admin", "formateur" = "Formateur", "apprenant" = "Apprenant", "cm" = "Cm", "user"="User"})
 * @ApiFilter(BooleanFilter::class, properties={"IsDeleted"})
 * @ApiResource(
 *     attributes={"deserialize"=false},
 *     normalizationContext={"groups"={"user:read"}},
 *     routePrefix="/admin",
 *      collectionOperations={
 *          "get_users"={
 *              "method"="GET",
 *              "path"="/users",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"= "Vous n'avez pas acces à cette ressource",
 *          },
 *          "add_users"={
 *              "method"="POST",
 *              "path"="/users",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"= "Vous n'avez pas acces à cette ressource",
 *              "route_name"="add_user"
 *          }    
 *      },
 *      itemOperations={
 *          "get_user"={
 *               "method"="GET",
 *               "path"="/users/{id}",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"= "Vous n'avez pas acces à cette ressource",
 *          },
 *           "update"={
 *                 "method"="PUT",
 *                 "path"="/users/{id}",
 *                 "security"="is_granted('ROLE_ADMIN')",
 *                 "security_message"= "Vous n'avez pas acces à cette ressource",
 *         }
 * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *  @Groups("user:read")
     * @Assert\NotBlank(message="Veuillez renseigné l'email ")
     * 
     * 
     */
    protected $email;

    
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Veuillez renseigné le password ")
     * 
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("user:read")
     * @Assert\NotBlank(message="Veuillez renseigné le nom ")
     * 
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("user:read")
     * @Assert\NotBlank(message="Veuillez renseigné le prenom ")
     * 
     */

    protected $prenom;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="user")
     * 
     */
    protected $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    protected $avatar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isDeleted = false;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.strtoupper($this->getProfil()->getLibelle());


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

   
    public function getAvatar()
    {
        return $this->avatar;

    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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
