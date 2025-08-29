<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[UniqueEntity(fields: ['member', 'song'], message: 'Ce membre a déjà voté pour ce morceau.')]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Owning side pour éviter d’éditer Member
    #[ORM\ManyToOne(targetEntity: Member::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[ORM\ManyToOne(targetEntity: Song::class, inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Song $song = null;

    // Instruments choisis par le membre pour jouer ce morceau (>= 2)
    // Unidirectionnel pour éviter d’éditer Instrument
    #[ORM\ManyToMany(targetEntity: Instrument::class)]
    #[ORM\JoinTable(name: 'vote_instrument')]
    #[Assert\Count(min: 2, minMessage: 'Vous devez choisir au moins 2 instruments.')]
    private Collection $chosenInstruments;

    public function __construct()
    {
        $this->chosenInstruments = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getMember(): ?Member { return $this->member; }
    public function setMember(?Member $member): self { $this->member = $member; return $this; }

    public function getSong(): ?Song { return $this->song; }
    public function setSong(?Song $song): self { $this->song = $song; return $this; }

    /** @return Collection<int, Instrument> */
    public function getChosenInstruments(): Collection { return $this->chosenInstruments; }
    public function addChosenInstrument(Instrument $instrument): self
    {
        if (!$this->chosenInstruments->contains($instrument)) {
            $this->chosenInstruments->add($instrument);
        }
        return $this;
    }
    public function removeChosenInstrument(Instrument $instrument): self
    {
        $this->chosenInstruments->removeElement($instrument);
        return $this;
    }
}