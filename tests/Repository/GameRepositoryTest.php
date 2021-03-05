<?php declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Game;
use App\Exception\DataNotFoundException;
use App\Repository\GameRepository;
use App\Repository\GameRepositoryInterface;

class GameRepositoryTest extends AbstractRepositoryTest
{
    private GameRepositoryInterface $repository;

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

    public function testNotFoundById(): void
    {
        $this->expectException(DataNotFoundException::class);
        $this->repository->getById(1);
    }

    protected function getNeededEntityClasses(): array
    {
        return [Game::class];
    }
}
