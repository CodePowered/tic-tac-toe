<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;

class GameApiControllerTest extends AbstractControllerTest
{
    public function testStartNewGame(): void
    {
        $this->client->request('POST', '/game', [], [], [], '{"strategy":"random","playerMark":"X"}');
        $response = $this->client->getResponse();

        self::assertEquals(201, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            '{"id":1,"board":[["-","-","-"],["-","-","-"],["-","-","-"]],'
                . '"status":"in progress","strategy":"random","playerMark":"X"}',
            $response->getContent()
        );
    }

    public function testMakeMove(): void
    {
        $repository = $this->getRealService(GameRepository::class);
        $repository->save(new Game('random', 'X'));

        $this->client->request('POST', '/move', [], [], [], '{"game":1,"row":1,"column":2,"mark":"X"}');
        $response = $this->client->getResponse();
        $jsonArray = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals(201, $response->getStatusCode());
        self::assertArraySubset(
            [
                "id" => 1,
                "status" => "in progress",
                "strategy" => "random",
                "playerMark" => "X",
                "opponentMove" => [
                    "game" => "1",
                    "mark" => "O",
                ],
            ], $jsonArray
        );
    }

    public function testActiveGame(): void
    {
        $repository = $this->getRealService(GameRepository::class);
        $repository->save(new Game('random', 'O', '------XO-'));

        $this->client->request('GET', '/game/active');
        $response = $this->client->getResponse();

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            '{"id":1,"board":[["-","-","-"],["-","-","-"],["X","O","-"]],'
            . '"status":"in progress","strategy":"random","playerMark":"O"}',
            $response->getContent()
        );
    }

    protected function getNeededEntityClasses(): array
    {
        return [Game::class];
    }
}
