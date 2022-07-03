<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 30)]
    private string $jobTitle;

    #[ORM\Column(type: 'string', length: 100)]
    private string $workplace;

    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(type: 'boolean')]
    private bool $isValid = false;

    #[ORM\ManyToOne(targetEntity: Consultant::class, inversedBy: 'jobOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultant $consultant;

    #[ORM\ManyToOne(targetEntity: Recruiter::class, inversedBy: 'jobOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recruiter $recruiter;

    #[ORM\ManyToMany(targetEntity: Candidate::class, inversedBy: 'jobOffers')]
    private ArrayCollection $candidate;

    #[Pure] public function __construct()
    {
        $this->candidate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getWorkplace(): ?string
    {
        return $this->workplace;
    }

    public function setWorkplace(string $workplace): self
    {
        $this->workplace = $workplace;

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

    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(?Consultant $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }

    public function getRecruiter(): ?Recruiter
    {
        return $this->recruiter;
    }

    public function setRecruiter(?Recruiter $recruiter): self
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidate(): Collection
    {
        return $this->candidate;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidate->contains($candidate)) {
            $this->candidate[] = $candidate;
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        $this->candidate->removeElement($candidate);

        return $this;
    }
}
