<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Repository\RepositoryTestTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    use RepositoryTestTrait;

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->createSchema($this->getNeededEntityClasses());
    }
}
