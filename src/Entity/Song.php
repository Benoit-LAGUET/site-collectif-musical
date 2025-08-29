<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'song', indexes: [new ORM\Index(name: 'idx_song_title', columns: ['title'])])]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private string $title;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $artist = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $youtubeLink = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $inSetlist = false;

    #[ORM\ManyToMany(targetEntity: Instrument::class)]
    #[ORM\JoinTable(name: 'song_instrument')]
    private Collection $instruments;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
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
}