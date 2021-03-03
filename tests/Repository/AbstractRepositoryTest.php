<?php declare(strict_types=1);

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractRepositoryTest extends KernelTestCase
{
    use RepositoryTestTrait;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->createSchema($this->getNeededEntityClasses());
    }

    protected function getRealService(string $className): object
    {
        return self::$container->get($className);
    }
}
