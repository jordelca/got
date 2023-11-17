<?php

namespace App\Actors\Infrastructure\Entity;

use App\Characters\Infrastructure\Entity\Character;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`actor`')]
class Actor
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $link;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private array $seasonsActive;

    #[ORM\JoinTable(name: 'actor_character')]
    #[ORM\JoinColumn(name: 'actor_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'character_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'actors')]
    private Collection $characters;

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

    public function getSeasonsActive(): array
    {
        return $this->seasonsActive;
    }

    public function setSeasonsActive(array $seasonsActive): void
    {
        $this->seasonsActive = $seasonsActive;
    }

    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function setCharacters(Collection $characters): void
    {
        $this->characters = $characters;
    }
}
