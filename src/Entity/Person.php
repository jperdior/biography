<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{

    const MASCULINE_TREATMENT = 0;
    const FEMENINE_TREATMENT = 1;
    const NEUTRAL_TREATMENT = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    #[Groups(["person:read"])]
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $treatment;

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
     * @ORM\Column(type="json",nullable=true)
     */
    #[Groups(["person:read","person:write"])]
    private $nicknames = [];

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
    #[Groups(["person:read","person:write"])]
    private $needsLogin = false;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(["person:read","person:write"])]
    private $allowNotesOrGalleries = true;

    /**
     * @ORM\OneToMany(targetEntity="Familiar", mappedBy="child", cascade={"persist","remove"})
     */
    #[Groups(["person:read"])]
    private $parents;

    /**
     * @ORM\OneToMany(targetEntity="Familiar", mappedBy="parent", cascade={"persist","remove"})
     */
    #[Groups(["person:read"])]
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

    /**
     * @ORM\OneToMany(targetEntity="Favorite", mappedBy="person", cascade={"persist"})
     */
    #[Groups("person:read")]
    private $favorites;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="persons")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups("person:read")]
    public $mainPerson = false;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    #[Groups("person:read")]
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    #[Groups("person:read")]
    private $updated;

    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"description"})
     */
    #[Groups("person:read")]
    private $contentChanged;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="person", cascade={"persist","remove"})
     */
    #[Groups(["person:read"])]
    private $notes;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): Uuid
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

    public function getNeedsLogin(): ?bool
    {
        return $this->needsLogin;
    }

    public function setNeedsLogin(?bool $needsLogin): self
    {
        $this->needsLogin = $needsLogin;

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

    public function getNicknames(): ?array
    {
        return $this->nicknames;
    }

    public function setNicknames(array $nicknames): self
    {
        $this->nicknames = $nicknames;

        return $this;
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setPerson($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getPerson() === $this) {
                $favorite->setPerson(null);
            }
        }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOwner(){
        return $this->user;
    }

    public function getMainPerson(): ?bool
    {
        return $this->mainPerson;
    }

    public function setMainPerson(bool $mainPerson): self
    {
        $this->mainPerson = $mainPerson;

        return $this;
    }

    /**
     * @return Collection|Familiar[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Familiar $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    public function removeParent(Familiar $parent): self
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection|Familiar[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Familiar $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
        }

        return $this;
    }

    public function removeChild(Familiar $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getContentChanged(): ?\DateTimeInterface
    {
        return $this->contentChanged;
    }

    public function setContentChanged(?\DateTimeInterface $contentChanged): self
    {
        $this->contentChanged = $contentChanged;

        return $this;
    }

    public function getAllowNotesOrGalleries(): ?bool
    {
        return $this->allowNotesOrGalleries;
    }

    public function setAllowNotesOrGalleries(bool $allowNotesOrGalleries): self
    {
        $this->allowNotesOrGalleries = $allowNotesOrGalleries;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setPerson($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPerson() === $this) {
                $note->setPerson(null);
            }
        }

        return $this;
    }

}
