<?php declare(strict_types=1);

namespace App\Model;

use App\Entity\Game as GameEntity;

class GameWithOpponentMove extends Game
{
    private ?Move $opponentMove;

    public function __construct(
        int $id,
        string $strategy,
        string $playerMark,
        array $board,
        string $status,
        ?Move $opponentMove = null
    ) {
        parent::__construct($id, $strategy, $playerMark, $board, $status);

        $this->opponentMove = $opponentMove;
    }

    public static function fromEntityAndMove(GameEntity $gameEntity, ?Move $move): self
    {
        return new static(
            $gameEntity->getId(),
            $gameEntity->getStrategy(),
            $gameEntity->getPlayerMark(),
            static::splitBoard($gameEntity->getBoard()),
            $gameEntity->getStatus(),
            $move
        );
    }

    public function getOpponentMove(): ?Move
    {
        return $this->opponentMove;
    }
}
