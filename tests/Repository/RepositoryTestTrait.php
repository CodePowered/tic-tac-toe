<?php declare(strict_types=1);

namespace App\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

trait RepositoryTestTrait
{
    private SchemaTool $schemaTool;
    private array $classesMetadata;

    protected function createSchema(array $classNames): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->classesMetadata = array_map(
            static fn(string $className) => $entityManager->getMetadataFactory()->getMetadataFor($className),
            $classNames
        );

        $this->schemaTool = new SchemaTool($entityManager);
        $this->schemaTool->createSchema($this->classesMetadata);
    }

    private function dropSchema(): void
    {
        $this->schemaTool->dropSchema($this->classesMetadata);
    }

    protected function tearDown(): void
    {
        $this->dropSchema();
        parent::tearDown();
    }

    /**
     * Get list of entity classes needed to load database schemas.
     *
     * @return string[]
     */
    abstract protected function getNeededEntityClasses(): array;
}
