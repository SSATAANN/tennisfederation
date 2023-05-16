<?php
// src/Entity/Reclamation.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="text")
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
    public function getDescription(): ?string
    {
        return $this->description;
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
