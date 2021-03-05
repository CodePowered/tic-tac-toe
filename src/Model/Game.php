<?php declare(strict_types=1);

namespace App\Model;

use App\Entity\Game as GameEntity;

class Game extends AbstractGame
{
    // Statuses from player point of view
    public const STATUS_IN_PROGRESS = 'in progress';
    public const STATUS_WON = 'won';
    public const STATUS_LOST = 'lost';
    public const STATUS_DRAW = 'draw';

    public const BOARD_SIZE = 3;

    private int $id;
    private array $board;
    private string $status;

    public function __construct(int $id, string $strategy, string $playerMark, array $board, string $status) {
        parent::__construct($strategy, $playerMark);

        $this->id = $id;
        $this->board = $board;
        $this->status = $status;
    }

    public static function fromEntity(GameEntity $gameEntity): self
    {
        return new static(
            $gameEntity->getId(),
            $gameEntity->getStrategy(),
            $gameEntity->getPlayerMark(),
            static::splitBoard($gameEntity->getBoard()),
            $gameEntity->getStatus(),
        );
    }

    protected static function splitBoard(string $board): array
    {
        return array_map(
            static fn(string $columns) => str_split($columns),
            str_split($board, self::BOARD_SIZE)
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
