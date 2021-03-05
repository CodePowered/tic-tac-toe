<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Game as GameEntity;
use App\Model\Game as GameModel;
use App\Repository\GameRepository;

class GamePageControllerTest extends AbstractControllerTest
{
    public function testPage(): void
    {
        $repository = $this->getRealService(GameRepository::class);
        $repository->save(new GameEntity('', 'X', '---------', GameModel::STATUS_DRAW));
        $repository->save(new GameEntity('', 'O', '---------', GameModel::STATUS_WON));
        $repository->save(new GameEntity('', 'X', '---------', GameModel::STATUS_LOST));
        $repository->save(new GameEntity('', 'X', '---------', GameModel::STATUS_WON));
        $repository->save(new GameEntity('', 'O', '---------', GameModel::STATUS_WON));
        $repository->save(new GameEntity('', 'O', '---------', GameModel::STATUS_DRAW));


        $this->client->request('GET', '/');
        $response = $this->client->getResponse();

        self::assertEquals(200, $response->getStatusCode());
        self::assertSelectorTextSame('#statistics-total', '6');
        self::assertSelectorTextSame('#statistics-won', '3');
        self::assertSelectorTextSame('#statistics-lost', '1');
        self::assertSelectorTextSame('#statistics-draw', '2');
    }

    protected function getNeededEntityClasses(): array
    {
        return [GameEntity::class];
    }
}
