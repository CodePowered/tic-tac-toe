<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Game;

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

    protected function getNeededEntityClasses(): array
    {
        return [Game::class];
    }
}
