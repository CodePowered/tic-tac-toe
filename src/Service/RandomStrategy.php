<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use App\Model\Game as GameModel;
use App\Model\Move;

class RandomStrategy implements AiStrategyInterface
{
    private const KEY = 'random';
    private const NAME = 'Random';

    public function getKey(): string
    {
        return self::KEY;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getAiMove(Game $game) : Move
    {
        $size = GameModel::BOARD_SIZE;
        $aiMark = $game->getPlayerMark() === GameModel::MARK_CROSS ? GameModel::MARK_NOUGHT : GameModel::MARK_CROSS;
        $position = array_rand(
            array_filter(
                str_split($game->getBoard()),
                static fn(string $mark) => $mark === GameModel::MARK_EMPTY
            )
        );

        return new Move($game->getId(), (int) floor($position / $size), $position % $size, $aiMark);
    }
}
