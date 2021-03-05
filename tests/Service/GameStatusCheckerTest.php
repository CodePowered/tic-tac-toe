<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Game as GameEntity;
use App\Model\Game as GameModel;
use App\Service\GameStatusChecker;
use PHPUnit\Framework\TestCase;

class GameStatusCheckerTest extends TestCase
{
    /**
     * @dataProvider getCheckData
     */
    public function testCheck(GameEntity $game, string $expectedStatus): void {
        self::assertEquals($expectedStatus, (new GameStatusChecker())->check($game));
    }

    public function getCheckData(): array {
        return [
            'lost-1st-row-O' => [new GameEntity('', 'X', 'OOOXX---X'), GameModel::STATUS_LOST],
            'won-2nd-col-O' => [new GameEntity('', 'O', '-O-XO--OX'), GameModel::STATUS_WON],
            'won-right-diagonal-X' => [new GameEntity('', 'X', 'X-XOX-XOO'), GameModel::STATUS_WON],
            'draw' => [new GameEntity('', 'X', 'XOXOOXXXO'), GameModel::STATUS_DRAW],
            'in-progress' => [new GameEntity('', 'O', 'XOXO-XXXO'), GameModel::STATUS_IN_PROGRESS],
        ];
    }
}
