<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeLink = null;

    #[ORM\Column(type: 'boolean')]
    private bool $inSetlist = false;

    // Instruments nécessaires pour jouer ce morceau
    // Unidirectionnel pour éviter de toucher à Instrument
    #[ORM\ManyToMany(targetEntity: Instrument::class)]
    #[ORM\JoinTable(name: 'song_instrument')]
    private Collection $instruments;

    // Votes associés à ce morceau (navigation utile pour l'affichage public)
    #[ORM\OneToMany(mappedBy: 'song', targetEntity: Vote::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $votes;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title ?? 'Morceau';
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }

    public function getArtist(): ?string { return $this->artist; }
    public function setArtist(?string $artist): self { $this->artist = $artist; return $this; }

    public function getYoutubeLink(): ?string { return $this->youtubeLink; }
    public function setYoutubeLink(?string $youtubeLink): self { $this->youtubeLink = $youtubeLink; return $this; }

    public function isInSetlist(): bool { return $this->inSetlist; }
    public function setInSetlist(bool $inSetlist): self { $this->inSetlist = $inSetlist; return $this; }

    /** @return Collection<int, Instrument> */
    public function getInstruments(): Collection { return $this->instruments; }
    public function addInstrument(Instrument $instrument): self
    {
        if (!$this->instruments->contains($instrument)) {
            $this->instruments->add($instrument);
        }
        return $this;
    }
    public function removeInstrument(Instrument $instrument): self
    {
        $this->instruments->removeElement($instrument);
        return $this;
    }

    /** @return Collection<int, Vote> */
    public function getVotes(): Collection { return $this->votes; }
    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setSong($this);
        }
        return $this;
    }
    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            if ($vote->getSong() === $this) {
                $vote->setSong(null);
            }
        }
        return $this;
    }
}