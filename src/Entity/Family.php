<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Controller\Family\CreateFamily;

/**
 * @ORM\Entity(repositoryClass=FamilyRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'controller' => CreateFamily::class,
        ]
    ],
    itemOperations: ['get', 'put', 'delete'],
)]
class Family
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
     * @ORM\OneToMany(targetEntity="Person", mappedBy="family")
     */
    private $persons;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;


    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->persons = new ArrayCollection();
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

    /**
     * @return Collection|Person[]
     */
    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->persons->contains($person)) {
            $this->persons[] = $person;
            $person->setFamily($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->persons->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getFamily() === $this) {
                $person->setFamily(null);
            }
        }

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
}
