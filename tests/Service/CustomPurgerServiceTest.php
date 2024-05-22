<?php

namespace App\Tests\Service;

use App\DataFixtures\AppPurger;
use App\Service\CustomPurgerService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CustomPurgerServiceTest extends TestCase
{
    private $entityManager;
    private $customPurgerService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->customPurgerService = new CustomPurgerService();
    }

    public function testCreateForEntityManager()
    {
        $excluded = ['some_table'];
        $purgeWithTruncate = true;

        $purger = $this->customPurgerService->createForEntityManager(null, $this->entityManager, $excluded, $purgeWithTruncate);

        $this->assertInstanceOf(AppPurger::class, $purger);
        $this->assertInstanceOf(PurgerInterface::class, $purger);

        $this->assertEquals(ORMPurger::PURGE_MODE_TRUNCATE, $purger->getPurgeMode());
    }
}
