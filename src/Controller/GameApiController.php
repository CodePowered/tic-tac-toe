<?php

namespace App\Controller;

use App\Model\Move;
use App\Model\NewGame;
use App\Service\GameManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GameApiController extends AbstractApiController
{
    private GameManager $gameManager;

    public function __construct(SerializerInterface $serializer, GameManager $gameManager)
    {
        parent::__construct($serializer);

        $this->gameManager = $gameManager;
    }

    /**
     * @Route("/game", name="start_new_game", methods={"POST"})
     */
    public function startNewGame(Request $request): Response
    {
        $game = $this->gameManager->createNewGame(
            $this->buildObject(NewGame::class, $request)
        );

        return $this->buildResponse($game, Response::HTTP_CREATED);
    }

    /**
     * @Route("/move", name="make_move", methods={"POST"})
     */
    public function makeMove(Request $request): Response {
        $move = $this->gameManager->makeMove($this->buildObject(Move::class, $request));

        return $this->buildResponse($move, Response::HTTP_CREATED);
    }
}
