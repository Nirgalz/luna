<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'users')]
    private Collection $roles;

    /**
     * @var Collection<int, Sobject>
     */
    #[ORM\OneToMany(targetEntity: Sobject::class, mappedBy: 'author')]
    private Collection $sobjects;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->sobjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role)
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Role $role)
    {
        if ($this->roles->removeElement($role)) {
            $role->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Sobject>
     */
    public function getSobjects(): Collection
    {
        return $this->sobjects;
    }

    public function addSobject(Sobject $sobject)
    {
        if (!$this->sobjects->contains($sobject)) {
            $this->sobjects->add($sobject);
            $sobject->setAuthor($this);
        }

        return $this;
    }

    public function removeSobject(Sobject $sobject)
    {
        if ($this->sobjects->removeElement($sobject)) {
            // set the owning side to null (unless already changed)
            if ($sobject->getAuthor() === $this) {
                $sobject->setAuthor(null);
            }
        }

        return $this;
    }
}
