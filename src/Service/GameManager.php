<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Game as GameEntity;
use App\Model\NewGame;
use App\Repository\GameRepository;
use App\Model\Game as GameModel;

class GameManager
{
    private GameRepository $gameRepository;
    private GameValidator $gameValidator;

    public function __construct(GameRepository $gameRepository, GameValidator $gameValidator)
    {
        $this->gameRepository = $gameRepository;
        $this->gameValidator = $gameValidator;
    }

    public function createNewGame(NewGame $game): GameModel
    {
        $this->gameValidator->validateNewGame($game);
        $gameEntity = $this->gameRepository->save(new GameEntity($game->getStrategy(), $game->getPlayerMark()));

        return GameModel::fromEntity($gameEntity);
    }
}
