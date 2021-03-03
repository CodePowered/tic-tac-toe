<?php declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Game;
use App\Repository\GameRepository;

class GameRepositoryTest extends AbstractRepositoryTest
{
    private GameRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getRealService(GameRepository::class);
    }

    public function testSave(): void
    {
        self::assertEquals(
            new Game('any', 'O', '---------', 'in progress', 1),
            $this->repository->save(new Game('any', 'O'))
        );
    }

    protected function getNeededEntityClasses(): array
    {
        return [Game::class];
    }
}
