<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @groups({"job_browse", "job_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"job_read"})
     */
    private $entitled;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"job_read"})
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"job_read"})
     */
    private $dateTill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @groups({"job_read"})
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     * @groups({"job_read"})
     */
    private $nbVacancy;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"job_read"})
     */
    private $place;

    /**
     * @ORM\Column(type="text")
     * @groups({"job_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @groups({"job_read"})
     */
    private $isValid;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"job_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @groups({"job_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"job_read"})
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity=Apply::class, mappedBy="Job")
     */
    private $applies;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="jobs")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="jobs")
     */
    private $category;

    public function __construct()
    {
        $this->applies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntitled(): ?string
    {
        return $this->entitled;
    }

    public function setEntitled(string $entitled): self
    {
        $this->entitled = $entitled;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTill(): ?\DateTimeInterface
    {
        return $this->dateTill;
    }

    public function setDateTill(\DateTimeInterface $dateTill): self
    {
        $this->dateTill = $dateTill;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getNbVacancy(): ?int
    {
        return $this->nbVacancy;
    }

    public function setNbVacancy(int $nbVacancy): self
    {
        $this->nbVacancy = $nbVacancy;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection<int, Apply>
     */
    public function getApplies(): Collection
    {
        return $this->applies;
    }

    public function addApply(Apply $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
            $apply->setJob($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->removeElement($apply)) {
            // set the owning side to null (unless already changed)
            if ($apply->getJob() === $this) {
                $apply->setJob(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
