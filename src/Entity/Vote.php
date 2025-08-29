<?php

namespace App\\Entity;

use Doctrine\\Common\\Collections\\ArrayCollection;
use Doctrine\\Common\\Collections\\Collection;
use Doctrine\\ORM\\Mapping as ORM;
use App\\Validator\\AtLeastTwoInstruments;
use App\\Validator\\ChosenInstrumentsBelongToSong;

#[ORM\\Entity]
#[ORM\\Table(name: 'vote', uniqueConstraints: [new ORM\\UniqueConstraint(name: 'uniq_vote_member_song', columns: ['member_id', 'song_id'])])]
#[ChosenInstrumentsBelongToSong]
class Vote
{
    #[ORM\\Id]
    #[ORM\\GeneratedValue]
    #[ORM\\Column]
    private ?int $id = null;

    #[ORM\\ManyToOne(targetEntity: Member::class)]
    #[ORM\\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[ORM\\ManyToOne(targetEntity: Song::class)]
    #[ORM\\JoinColumn(nullable: false)]
    private ?Song $song = null;

    #[ORM\\ManyToMany(targetEntity: Instrument::class)]
    #[ORM\\JoinTable(name: 'vote_instrument')]
    #[AtLeastTwoInstruments]
    private Collection $instruments;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getMember(): ?Member { return $this->member; }
    public function setMember(?Member $member): self { $this->member = $member; return $this; }

    public function getSong(): ?Song { return $this->song; }
    public function setSong(?Song $song): self { $this->song = $song; return $this; }

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