<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

class AppPurger extends ORMPurger
{
	public function __construct(private readonly EntityManagerInterface $entityManager, array $excluded = [])
	{
		parent::__construct($this->entityManager, $excluded);
	}

	/**
	 * Purges the database with temporarily disabled foreign key checks.
	 *
	 * {@inheritDoc}
	 */
	public function purge(): void
	{
		$connection = $this->entityManager->getConnection();

		try {
			$connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0');
			parent::purge();
		} finally {
			$connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1');
		}

		$this->resetAutoincrement();
	}

	private function resetAutoincrement(): void
	{
		$connection = $this->entityManager->getConnection();

		$database = $connection->getDatabase();

		$sql = sprintf('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = "%s" AND TABLE_TYPE = "BASE TABLE"', $database);
		$statement = $connection->prepare($sql);
		$rows = $statement->executeQuery()->fetchAllAssociative();
		foreach ($rows as $row) {
			$tableName = $row['TABLE_NAME'];
			$sql = sprintf('ALTER TABLE `%s`.%s AUTO_INCREMENT = 1', $database, $tableName);
			$connection->executeStatement($sql);
		}
	}
}
