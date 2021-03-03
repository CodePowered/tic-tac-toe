<?php declare(strict_types=1);

namespace App\Service;

use App\Model\NewGame;

class GameValidator extends AbstractValidator
{
    public function validateNewGame(NewGame $game): void
    {
        $this->throwFirstErrorAsException(
            $this->validator->validate($game, null, [NewGame::VALIDATOR_GROUP_NEW_GAME])
        );
    }
}
