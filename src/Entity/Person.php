<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: ['get', 'put', 'delete'],
)]
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastnames;

    /**
     * @ORM\Column(type="json")
     */
    private $nicknames;

    /**
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="persons")
     * @ORM\JoinColumn(name="family_id", referencedColumnName="id")
     */
    private $family;

    /**
     * @ORM\Column(type="boolean")
     */
    private $needsLogin = false;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastnames(): ?string
    {
        return $this->lastnames;
    }

    public function setLastnames(string $lastnames): self
    {
        $this->lastnames = $lastnames;

        return $this;
    }

    public function getNeedsLogin(): ?bool
    {
        return $this->needsLogin;
    }

    public function setNeedsLogin(bool $needsLogin): self
    {
        $this->needsLogin = $needsLogin;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }
}
