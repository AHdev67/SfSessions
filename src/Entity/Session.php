<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $intituleSession = null;

    #[ORM\Column]
    private ?int $nbPlaces = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'session', orphanRemoval: true)]
    private Collection $programmeSession;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formation $formationSession = null;

    public function __construct()
    {
        $this->programmeSession = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleSession(): ?string
    {
        return $this->intituleSession;
    }

    public function setIntituleSession(string $intituleSession): static
    {
        $this->intituleSession = $intituleSession;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): static
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammeSession(): Collection
    {
        return $this->programmeSession;
    }

    public function addProgrammeSession(Programme $programmeSession): static
    {
        if (!$this->programmeSession->contains($programmeSession)) {
            $this->programmeSession->add($programmeSession);
            $programmeSession->setSession($this);
        }

        return $this;
    }

    public function removeProgrammeSession(Programme $programmeSession): static
    {
        if ($this->programmeSession->removeElement($programmeSession)) {
            // set the owning side to null (unless already changed)
            if ($programmeSession->getSession() === $this) {
                $programmeSession->setSession(null);
            }
        }

        return $this;
    }

    public function getFormationSession(): ?Formation
    {
        return $this->formationSession;
    }

    public function setFormationSession(?Formation $formationSession): static
    {
        $this->formationSession = $formationSession;

        return $this;
    }
}