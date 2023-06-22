<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CandidateRepository::class)
 */
class Candidate extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups({"job_read"})
     * @groups({"candidate_browse", "candidate_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @groups({"job_read"})
     * @groups({"candidate_browse"})
     * @groups({"candidate_read"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @groups({"candidate_browse"})
     * @groups({"candidate_read"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Apply::class, mappedBy="candidate")
     */
    private $applies;

    public function __construct()
    {
        $this->applies = new ArrayCollection();
    }

    /**public function getId(): ?int
    {
        dd($this);
        return $this->id;
    }
    */

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
            $apply->setCandidate($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->removeElement($apply)) {
            // set the owning side to null (unless already changed)
            if ($apply->getCandidate() === $this) {
                $apply->setCandidate(null);
            }
        }

        return $this;
    }

}
