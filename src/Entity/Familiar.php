<?php

namespace App\Entity;

use App\Repository\FamiliarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FamiliarRepository::class)
 */
class Familiar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["person:read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $lastnames;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups("person:read")]
    private $mainPicture;

    #[Groups("person:read")]
    public $mainPictureBase64;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="parents")
     * @ORM\JoinColumn(name="child_id", referencedColumnName="id")
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastnames(): ?string
    {
        return $this->lastnames;
    }

    public function setLastnames(?string $lastnames): self
    {
        $this->lastnames = $lastnames;

        return $this;
    }

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getChild(): ?Person
    {
        return $this->child;
    }

    public function setChild(?Person $child): self
    {
        $this->child = $child;

        return $this;
    }

    public function getParent(): ?Person
    {
        return $this->parent;
    }

    public function setParent(?Person $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
