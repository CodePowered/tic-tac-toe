<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use App\Exception\DataNotFoundException;

interface GameRepositoryInterface
{
    public function save(Game $game): Game;

    /**
     * @throws DataNotFoundException
     */
    public function getById(int $id): Game;

    public function findOneInProgress(): ?Game;

    public function countByStatus(string $status): int;
}
