<?php declare(strict_types=1);

namespace App\Model;

class Statistics
{
    private int $won;
    private int $lost;
    private int $draw;

    public function __construct(int $won, int $lost, int $draw)
    {
        $this->won = $won;
        $this->lost = $lost;
        $this->draw = $draw;
    }

    public function getTotal(): int
    {
        return $this->won + $this->lost + $this->draw;
    }

    public function getWon(): int
    {
        return $this->won;
    }

    public function getLost(): int
    {
        return $this->lost;
    }

    public function getDraw(): int
    {
        return $this->draw;
    }
}
