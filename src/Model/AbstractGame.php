<?php declare(strict_types=1);

namespace App\Model;

use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractGame
{
    public const MARK_EMPTY = '-';
    public const MARK_CROSS = 'X';
    public const MARK_NOUGHT = 'O';

    public const VALIDATOR_GROUP_NEW_GAME = 'new_game';

    public const VALID_PLAYER_MARKS = [
        self::MARK_CROSS,
        self::MARK_NOUGHT,
    ];

    /**
     * @AppAssert\IsAiStrategy(groups={AbstractGame::VALIDATOR_GROUP_NEW_GAME})
     */
    protected string $strategy;

    /**
     * @Assert\Choice(choices=AbstractGame::VALID_PLAYER_MARKS, groups={AbstractGame::VALIDATOR_GROUP_NEW_GAME})
     */
    protected string $playerMark;

    public function __construct(string $strategy, string $playerMark) {
        $this->strategy = $strategy;
        $this->playerMark = $playerMark;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function getPlayerMark(): string
    {
        return $this->playerMark;
    }
}
