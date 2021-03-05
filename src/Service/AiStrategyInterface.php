<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use App\Model\Move;

interface AiStrategyInterface
{
    public function getKey(): string;

    public function getName(): string;

    public function getAiMove(Game $game): Move;
}
