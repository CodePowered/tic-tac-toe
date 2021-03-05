<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Move
{
    public const MARK_EMPTY = '-';
    public const MARK_CROSS = 'X';
    public const MARK_NOUGHT = 'O';

    public const VALID_PLAYER_MARKS = [
        self::MARK_CROSS,
        self::MARK_NOUGHT,
    ];

    /**
     * @Assert\GreaterThan(0)
     */
    private int $game;

    /**
     * @Assert\Range(min=0, max=2)
     */
    private int $row;

    /**
     * @Assert\Range(min=0, max=2)
     */
    private int $column;

    /**
     * @Assert\Choice(choices=Move::VALID_PLAYER_MARKS)
     */
    private string $mark;

    public function __construct(int $game, int $row, int $column, string $mark)
    {
        $this->game = $game;
        $this->row = $row;
        $this->column = $column;
        $this->mark = $mark;
    }

    public function getGame(): int
    {
        return $this->game;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function getMark(): string
    {
        return $this->mark;
    }
}
