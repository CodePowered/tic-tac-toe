<?php declare(strict_types=1);

namespace App\Tests\Service;

trait ContainerHelperTestTrait
{
    protected function getRealService(string $className): object
    {
        return self::$container->get($className);
    }
}
