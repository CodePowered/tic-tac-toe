<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\UnsupportedException;

class AiStrategyCollection
{
    /**
     * @var AiStrategyInterface[] - key to instance map.
     */
    private array $strategies = [];

    /**
     * @param AiStrategyInterface[] $strategies
     */
    public function __construct(iterable $strategies)
    {
        foreach ($strategies as $strategy) {
            $this->strategies[$strategy->getKey()] = $strategy;
        }
    }

    /**
     * @throws UnsupportedException
     */
    public function getStrategy(string $strategyKey): AiStrategyInterface
    {
        if (isset($this->strategies[$strategyKey])) {
            return $this->strategies[$strategyKey];
        }

        throw new UnsupportedException('Unsupported strategy!');
    }

    public function getSupportedNames(): array
    {
        $names = [];

        foreach ($this->strategies as $strategy) {
            $names[$strategy->getKey()] = $strategy->getName();
        }

        return $names;
    }
}
