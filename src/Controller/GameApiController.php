<?php

namespace App\Controller;

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
}
