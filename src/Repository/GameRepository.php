<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use App\Exception\DataNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function save(Game $game): Game
    {
        $em = $this->getEntityManager();
        $em->persist($game);
        $em->flush();

        return $game;
    }

    /**
     * @throws DataNotFoundException
     */
    public function getById(int $id): Game
    {
        $game = $this->find($id);
        if ($game !== null) {
            return $game;
        }

        throw new DataNotFoundException(sprintf("Game '%d' doesn't exist", $id));
    }
}
