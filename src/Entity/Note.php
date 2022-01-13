<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["note:read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["note:write"])]
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["note:read","note:write"])]
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    #[Groups(["note:write"])]
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(["note:read","note:write"])]
    private $body;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verified = false;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(["note:read"])]
    private $approved = false;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="notes")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    private $verificationToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getVerificationToken()
    {
        return $this->verificationToken;
    }

    public function setVerificationToken($verificationToken): self
    {
        $this->verificationToken = $verificationToken;

        return $this;
    }

    public function isOwner(User $user){
        return $this->getPerson()->getUser()->getId() === $user->getId();
    }
}
