<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['person:read']],
    denormalizationContext: ['groups' => ['person:write']],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: ['get', 'put' => ['groups' => ['person:write']], 'delete'],
)]
class Person
{

    const MASCULINE_TREATMENT = 0;
    const FEMENINE_TREATMENT = 1;
    const NEUTRAL_TREATMENT = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    #[Groups(["person:read","person:write"])]
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $treatment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["person:read","person:write"])]
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["person:read","person:write"])]
    private $lastnames;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $birthplace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $deathplace;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $deathdate;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $description;


    /**
     * @ORM\Column(type="boolean")
     */
    private $needsLogin = false;

    /**
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="children", cascade={"persist"})
     * @MaxDepth(1)
     */
    #[Groups(["person:read","person:write"])]
    private $parents;

    /**
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="parents", cascade={"persist"})
     * @ORM\JoinTable(name="children_parents",
     *      joinColumns={@ORM\JoinColumn(name="children_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     * @MaxDepth(1)
     */
    #[Groups(["person:read","person:write"])]
    private $children;

    /**
     * @ORM\OneToOne(targetEntity="Person", cascade={"persist"})
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    #[Groups(["person:read","person:write"])]
    private $partner;

    /**
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="person")
     */
    #[Groups("person:read","person:write")]
    private $galleries;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->galleries = new ArrayCollection();
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

    /**
     * @return Collection|Person[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Person $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
            $parent->addChild($this);
        }

        return $this;
    }

    public function removeParent(Person $parent): self
    {
        if ($this->parents->removeElement($parent)) {
            $parent->removeChild($this);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Person $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
        }

        return $this;
    }

    public function removeChild(Person $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }

    public function getPartner(): ?self
    {
        return $this->partner;
    }

    public function setPartner(?self $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getBirthplace(): ?string
    {
        return $this->birthplace;
    }

    public function setBirthplace(?string $birthplace): self
    {
        $this->birthplace = $birthplace;

        return $this;
    }

    public function getDeathplace(): ?string
    {
        return $this->deathplace;
    }

    public function setDeathplace(?string $deathplace): self
    {
        $this->deathplace = $deathplace;

        return $this;
    }

    public function getDeathdate(): ?\DateTimeInterface
    {
        return $this->deathdate;
    }

    public function setDeathdate(?\DateTimeInterface $deathdate): self
    {
        $this->deathdate = $deathdate;

        return $this;
    }

    /**
     * @return Collection|Gallery[]
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): self
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries[] = $gallery;
            $gallery->setPerson($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        if ($this->galleries->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getPerson() === $this) {
                $gallery->setPerson(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTreatment(): ?int
    {
        return $this->treatment;
    }

    public function setTreatment(?int $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }
}
