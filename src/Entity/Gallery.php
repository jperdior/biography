<?php

namespace App\Entity;

use App\Controller\Gallery\CreateGallery;
use App\Controller\Gallery\UpdateGallery;
use App\Repository\GalleriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalleriesRepository::class)
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups("person:read")]
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $person;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups("person:read","person:write")]
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="gallery", cascade={"persist","remove"})
     */
    #[Groups("person:read")]
    private $images;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verified = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $approved = false;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setGallery($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getGallery() === $this) {
                $image->setGallery(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

}
