<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class Referee
{
    /**
 * @ORM\ManyToMany(targetEntity="App\Entity\Matcch", mappedBy="referees")
 */
private $matches;

public function __construct()
{
    $this->matches = new ArrayCollection();
}

public function getMatches(): Collection
{
    return $this->matches;
}

public function addMatch(Matcch $match): self
{
    if (!$this->matches->contains($match)) {
        $this->matches[] = $match;
        $match->addReferee($this);
    }

    return $this;
}

public function removeMatch(Matcch $match): self
{
    if ($this->matches->removeElement($match)) {
        $match->removeReferee($this);
    }

    return $this;
}
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    private $imageFilename;
    /**
     * @var File|null
     *
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"}
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;
    /**
    * @var string The hashed password
    * @ORM\Column(type="string")
    */

   private $password;
   /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
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
   /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }
  
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    // ... add more getters and setters as needed
}
