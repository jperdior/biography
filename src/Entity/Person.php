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

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    #[Groups(["person:read","person:write"])]
    private $id;

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

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
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
}
