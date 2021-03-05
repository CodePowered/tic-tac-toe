<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Game as GameEntity;
use App\Exception\DataNotFoundException;
use App\Exception\UnsupportedException;
use App\Model\GameWithOpponentMove;
use App\Model\Move;
use App\Model\NewGame;
use App\Repository\GameRepository;
use App\Model\Game as GameModel;

class GameManager
{
    private GameRepository $gameRepository;
    private GameValidator $gameValidator;
    private GameStatusChecker $statusChecker;
    private AiStrategyCollection $strategyCollection;

    public function __construct(
        GameRepository $gameRepository,
        GameValidator $gameValidator,
        GameStatusChecker $statusChecker,
        AiStrategyCollection $strategyCollection
    ) {
        $this->gameRepository = $gameRepository;
        $this->gameValidator = $gameValidator;
        $this->statusChecker = $statusChecker;
        $this->strategyCollection = $strategyCollection;
    }

    public function createNewGame(NewGame $game): GameModel
    {
        $this->gameValidator->validateNewGame($game);
        $gameEntity = $this->gameRepository->save(new GameEntity($game->getStrategy(), $game->getPlayerMark()));

        return GameModel::fromEntity($gameEntity);
    }

    /**
     * @throws DataNotFoundException|UnsupportedException
     */
    public function makeMove(Move $move): GameWithOpponentMove
    {
        $this->gameValidator->validateMove($move);
        $game = $this->gameRepository->getById($move->getGame());
        $game->setCell($move->getMark(), $this->getPosition($move));
        $status = $this->statusChecker->check($game);
        $aiMove = null;

        if ($status === GameModel::STATUS_IN_PROGRESS) {
            $aiMove = $this->strategyCollection->getStrategy($game->getStrategy())->getAiMove($game);
            $game->setCell($aiMove->getMark(), $this->getPosition($aiMove));
            $status = $this->statusChecker->check($game);
        }

        $game->setStatus($status);
        $game = $this->gameRepository->save($game);

        return GameWithOpponentMove::fromEntityAndMove($game, $aiMove);
    }

    private function getPosition(Move $move): int
    {
        return $move->getRow() * GameModel::BOARD_SIZE + $move->getColumn();
    }
}
