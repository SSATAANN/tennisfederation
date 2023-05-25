<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MatcchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatcchRepository::class)
 */
class Matcch
{
    /**
     * @ORM\ManyToMany(targetEntity=Player::class, inversedBy="matches")
     * @ORM\JoinTable(name="match_winner",
     *      joinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
     * )
     */
    private $winners;

    public function __construct()
    {
        $this->referees = new ArrayCollection();
        $this->winners = new ArrayCollection();
    }

    /**
     * @return Collection|Player[]
     */
    public function getWinners(): Collection
    {
        return $this->winners;
    }

    public function addWinner(Player $winner): self
    {
        if (!$this->winners->contains($winner)) {
            $this->winners[] = $winner;
        }

        return $this;
    }

    public function removeWinner(Player $winner): self
    {
        $this->winners->removeElement($winner);

        return $this;
    }
    /**
 * @ORM\ManyToMany(targetEntity="App\Entity\Referee", inversedBy="matches")
 * @ORM\JoinTable(name="match_referee",
 *     joinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id")},
 *     inverseJoinColumns={@ORM\JoinColumn(name="referee_id", referencedColumnName="id")}
 * )
 */
private $referees;



/**
 * @return Collection|Referee[]
 */
public function getReferees(): Collection
{
    return $this->referees;
}

public function addReferee(Referee $referee): self
{
    if (!$this->referees->contains($referee)) {
        $this->referees[] = $referee;
    }

    return $this;
}

public function removeReferee(Referee $referee): self
{
    $this->referees->removeElement($referee);

    return $this;
}
     /**
     * @ORM\PrePersist
     */
    public function updatePlayers()
    {
        if ($this->type === 'Single') {
            $this->player3 = null;
            $this->player4 = null;
        }
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;
    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tournament;
/**
 * @ORM\ManyToOne(targetEntity=Player::class)
 * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="SET NULL")
 */
private $player1;

/**
 * @ORM\ManyToOne(targetEntity=Player::class)
 * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="SET NULL")
 */
private $player2;
/**
 * @ORM\ManyToOne(targetEntity=Player::class)
 * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
 */
private $player3;

/**
 * @ORM\ManyToOne(targetEntity=Player::class)
 * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
 */
private $player4;


   /**
 * @ORM\ManyToOne(targetEntity="Player")
 * @ORM\JoinColumn(name="winner", referencedColumnName="id", onDelete="SET NULL")
 */

    private $winner;



    //-------------------
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    // ...
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(?string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
    // Ajoutez cette méthode pour afficher le résultat à un visiteur
    public function afficherResultat(): string
    {
        if ($this->resultat !== null) {
            return 'Résultat : ' . $this->resultat;
        } else {
            return 'Résultat non disponible';
        }
    }

//--------------------------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTournament(): ?string
    {
        return $this->tournament;
    }

    public function setTournament(string $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }
    public function getPlayer1(): ?Player
    {
        return $this->player1;
    }

    public function setPlayer1(?Player $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?Player
    {
        return $this->player2;
    }

    public function setPlayer2(?Player $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getPlayer3(): ?Player
    {
        return $this->player3;
    }

    public function setPlayer3(?Player $player3): self
    {
        $this->player3 = $player3;

        return $this;
    }

    public function getPlayer4(): ?Player
    {
        return $this->player4;
    }

    public function setPlayer4(?Player $player4): self
    {
        $this->player4 = $player4;

        return $this;
    }
    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }


}
