<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Game as GameEntity;
use App\Model\Game as GameModel;

class GameStatusChecker
{
    public function check(GameEntity $game): string
    {
        $boardString = $game->getBoard();
        $transformed = $this->transform($boardString);

        $combinations = [
            // rows
            substr($boardString, 0, 3),
            substr($boardString, 3, 3),
            substr($boardString, 6, 3),

            // columns
            substr($transformed, 0, 3),
            substr($transformed, 3, 3),
            substr($transformed, 6, 3),

            // diagonals
            $boardString[0] . $boardString[4] . $boardString[8],
            $boardString[2] . $boardString[4] . $boardString[6],
        ];

        $combinations = array_filter(
            $combinations,
            static fn(string $row) => $row === 'XXX' || $row === 'OOO'
        );

        // One side has one
        if (! empty($combinations)) {
            // Player
            if (strpos(reset($combinations), $game->getPlayerMark()) !== false) {
                return GameModel::STATUS_WON;
            }

            // Opponent / AI
            return GameModel::STATUS_LOST;
        }

        if (strpos($boardString, GameModel::MARK_EMPTY) !== false) {
            return GameModel::STATUS_IN_PROGRESS;
        }

        return GameModel::STATUS_DRAW;
    }

    private function transform(string $board): string {
        $size = GameModel::BOARD_SIZE;
        $transformed = '';

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $transformed .= $board[$j * $size + $i];
            }
        }

        return $transformed;
    }
}
