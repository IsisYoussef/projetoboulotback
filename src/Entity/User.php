<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user"="User", "candidate"="Candidate", "company"="Company"})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups({"candidate_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=64)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=64)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=64)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @groups({"candidate_browse","candidate_read"})
     * @groups({"company_browse", "company_read"})
     */
    private $gender;

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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}
