<?php declare(strict_types=1);

namespace App\Entity;

use App\Exception\InvalidActionException;
use App\Model\Game as GameModel;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    private const EMPTY_BOARD = '---------';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private string $strategy;

    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    private string $playerMark;

    /**
     * @ORM\Column(type="string", length=9, options={"fixed" = true})
     */
    private string $board;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private string $status;

    public function __construct(
        string $strategy,
        string $playerMark,
        string $board = self::EMPTY_BOARD,
        string $status = GameModel::STATUS_IN_PROGRESS,
        int $id = null
    ) {
        $this->strategy = $strategy;
        $this->playerMark = $playerMark;
        $this->board = $board;
        $this->status = $status;

        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function getPlayerMark(): string
    {
        return $this->playerMark;
    }

    public function getBoard(): string
    {
        return $this->board;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setCell(string $mark, int $position): self
    {
        if ($this->board[$position] !== GameModel::MARK_EMPTY) {
            throw new InvalidActionException('Cell cannot be changed!');
        }
        $this->board[$position] = $mark;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
