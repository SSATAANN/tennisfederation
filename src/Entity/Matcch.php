<?php

namespace App\Entity;

use App\Repository\MatcchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatcchRepository::class)
 */
class Matcch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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
 * @ORM\ManyToOne(targetEntity="Player")
 * @ORM\JoinColumn(name="winner", referencedColumnName="id", onDelete="CASCADE")
 */

    private $winner;

  /**
 * @ORM\ManyToOne(targetEntity="Player")
 * @ORM\JoinColumn(name="loser", referencedColumnName="id", onDelete="CASCADE")
 */

    private $loser;

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

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getLoser(): ?Player
    {
        return $this->loser;
    }

    public function setLoser(?Player $loser): self
    {
        $this->loser = $loser;

        return $this;
    }
}
