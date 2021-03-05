<?php declare(strict_types=1);

namespace App\Service;

use App\Model\Game as GameModel;
use App\Model\Statistics;
use App\Repository\GameRepositoryInterface;

class StatisticsProvider
{
    private GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function getStatistics(): Statistics
    {
        return new Statistics(
            $this->gameRepository->countByStatus(GameModel::STATUS_WON),
            $this->gameRepository->countByStatus(GameModel::STATUS_LOST),
            $this->gameRepository->countByStatus(GameModel::STATUS_DRAW),
        );
    }
}
