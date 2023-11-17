<?php

namespace App\Characters\Infrastructure\Entity;

use App\Actors\Infrastructure\Entity\Actor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $link;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $nickname;

    #[ORM\Column]
    private bool $royal = false;

    #[ORM\Column]
    private bool $kingsguard = false;

    #[ORM\Column]
    private string $imageThumb;

    #[ORM\Column]
    private string $imageFull;

    #[ORM\Column(type: 'json')]
    private array $houses = [];

    #[ORM\JoinTable(name: 'characters_allies')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'alliesWithMe')]
    private Collection $allies;

    #[ORM\JoinTable(name: 'characters_allies')]
    #[ORM\JoinColumn(name: 'character_source', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'character_target', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'allies')]
    private Collection $alliesWithMe;

    #[ORM\JoinTable(name: 'characters_married_engaged')]
    #[ORM\ManyToMany(targetEntity: Character::class)]
    private Collection $marriedEngaged;

    #[ORM\JoinTable(name: 'characters_siblings')]
    #[ORM\ManyToMany(targetEntity: Character::class)]
    private Collection $siblings;

    #[ORM\JoinTable(name: 'characters_guards')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'guards')]
    private Collection $guardedBy;

    #[ORM\JoinTable(name: 'characters_guards')]
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'guardedBy')]
    private Collection $guards;

    #[ORM\JoinTable(name: 'characters_parents')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'parentOf')]
    private Collection $parents;

    #[ORM\JoinTable(name: 'characters_parents')]
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'parents')]
    private Collection $parentOf;

    #[ORM\JoinTable(name: 'characters_serves')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'servedBy')]
    private Collection $serves;

    #[ORM\JoinTable(name: 'characters_serves')]
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'serves')]
    private Collection $servedBy;

    #[ORM\JoinTable(name: 'characters_kills')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'killedBy')]
    private Collection $killed;

    #[ORM\JoinTable(name: 'characters_kills')]
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'killed')]
    private Collection $killedBy;

    #[ORM\JoinTable(name: 'actor_character')]
    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'characters')]
    private Collection $actors;

    public function __construct()
    {
        $this->allies = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function isRoyal(): bool
    {
        return $this->royal;
    }

    public function setRoyal(bool $royal): void
    {
        $this->royal = $royal;
    }

    public function isKingsguard(): bool
    {
        return $this->kingsguard;
    }

    public function setKingsguard(bool $kingsguard): void
    {
        $this->kingsguard = $kingsguard;
    }

    public function getImageThumb(): string|null
    {
        return $this->imageThumb ?? null;
    }

    public function setImageThumb(string $imageThumb): void
    {
        $this->imageThumb = $imageThumb;
    }

    public function getImageFull(): string|null
    {
        return $this->imageFull ?? null;
    }

    public function setImageFull(string $imageFull): void
    {
        $this->imageFull = $imageFull;
    }

    public function getHouses(): array
    {
        return $this->houses;
    }

    public function setHouses(array $houses): void
    {
        $this->houses = $houses;
    }

    public function getAllies(): Collection
    {
        return new ArrayCollection(
            array_merge($this->allies->toArray(), $this->alliesWithMe->toArray()),
        );
    }

    public function setAllies(Collection $allies): void
    {
        $this->allies = $allies;
    }

    public function getGuardedBy(): Collection
    {
        return $this->guardedBy;
    }

    public function setGuardedBy(Collection $guardedBy): void
    {
        $this->guardedBy = $guardedBy;
    }

    public function getGuards(): Collection
    {
        return $this->guards;
    }

    public function setGuards(Collection $guards): void
    {
        $this->guards = $guards;
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function setParents(Collection $parents): void
    {
        $this->parents = $parents;
    }

    public function getParentOf(): Collection
    {
        return $this->parentOf;
    }

    public function setParentOf(Collection $parentOf): void
    {
        $this->parentOf = $parentOf;
    }

    public function getServes(): Collection
    {
        return $this->serves;
    }

    public function setServes(Collection $serves): void
    {
        $this->serves = $serves;
    }

    public function getServedBy(): Collection
    {
        return $this->servedBy;
    }

    public function setServedBy(Collection $servedBy): void
    {
        $this->servedBy = $servedBy;
    }

    public function getMarriedEngaged(): Collection
    {
        return $this->marriedEngaged;
    }

    public function setMarriedEngaged(Collection $marriedEngaged): void
    {
        $this->marriedEngaged = $marriedEngaged;
    }

    public function getSiblings(): Collection
    {
        return $this->siblings;
    }

    public function setSiblings(Collection $siblings): void
    {
        $this->siblings = $siblings;
    }

    public function getKilled(): Collection
    {
        return $this->killed;
    }

    public function setKilled(Collection $killed): void
    {
        $this->killed = $killed;
    }

    public function getKilledBy(): Collection
    {
        return $this->killedBy;
    }

    public function setKilledBy(Collection $killedBy): void
    {
        $this->killedBy = $killedBy;
    }

    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function setActors(Collection $actors): void
    {
        $this->actors = $actors;
    }
}
