<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["favorite:read","person:read"])]
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["favorite:read","favorite:write","person:read","person:write"])]
    private $type;


    /**
     * @ORM\Column(type="json",nullable=true)
     */
    #[Groups(["favorite:read","favorite:write","person:read","person:write"])]
    private $favorites = [];

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFavorites(): ?array
    {
        return $this->favorites;
    }

    public function setFavorites(?array $favorites): self
    {
        $this->favorites = $favorites;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
