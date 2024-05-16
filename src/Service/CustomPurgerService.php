<?php

namespace App\Service;

use App\DataFixtures\AppPurger;
use Doctrine\Bundle\FixturesBundle\Purger\PurgerFactory;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Fixtures custom purger
 * Override the default purger factory in order to skip foreign key checks.
 *
 * bin/console doctrine:fixtures:load --env=test --purger=fixtures_purger -n
 */
class CustomPurgerService implements PurgerFactory
{
	public function createForEntityManager(?string $emName, EntityManagerInterface $entityManager, array $excluded = [], bool $purgeWithTruncate = false): PurgerInterface
	{
		$appPurger = new AppPurger($entityManager, $excluded);
		$appPurger->setPurgeMode($purgeWithTruncate ? ORMPurger::PURGE_MODE_TRUNCATE : ORMPurger::PURGE_MODE_DELETE);

		return $appPurger;
	}
}
