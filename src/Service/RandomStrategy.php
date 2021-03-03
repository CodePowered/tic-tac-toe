<?php declare(strict_types=1);

namespace App\Service;

class RandomStrategy implements AiStrategyInterface
{
    private const KEY = 'random';
    private const NAME = 'Random';

    public function getKey(): string
    {
        return self::KEY;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
