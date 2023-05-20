<?php
// src/Entity/Reclamation.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sujet;

    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="The description field must not be empty.")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reclamations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    // Ajoutez les getters et setters pour les propriétés ci-dessus
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSujet(): ?string
    {
        return $this->sujet;
    }
    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
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
