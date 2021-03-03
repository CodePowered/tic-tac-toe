<?php declare(strict_types=1);

namespace App\Service;

interface AiStrategyInterface
{
    public function getKey(): string;

    public function getName(): string;
}
