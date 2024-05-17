<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
	final public const username1 = 'antoine';
	final public const username2 = 'didier';
	final public const username3 = 'jouni';
	final public const uBot1 = 'bot1';

	public function __construct(
		private readonly UserPasswordHasherInterface $userPasswordHasher,
		private readonly string $fixtureUserPassword
	) {
	}

	public function load(ObjectManager $objectManager): void
	{
		$this->loadUser($objectManager);
	}

	public function loadUser(ObjectManager $objectManager): void
	{
		$count = 0;
		foreach ($this->getUserdata() as [
			$username,
			$password,
			$roles,
		]) {
			$entity = new User();
			$entity->setUsername($username);
			if (null === $password) {
				$password = $this->userPasswordHasher->hashPassword($entity, $this->fixtureUserPassword);
			}
			$entity->setPassword($password);
			$entity->setRoles($roles);

			$objectManager->persist($entity);
			$this->addReference($username, $entity);
			$this->addReference(User::class.++$count, $entity);
		}
		$objectManager->flush();
	}

	private function getUserdata(): array
	{
		return [
			[self::username1, null, ['ROLE_ADMIN', 'ROLE_USER']],
			[self::username2, null, ['ROLE_ADMIN', 'ROLE_USER']],
			[self::username3, null, ['ROLE_ADMIN', 'ROLE_USER']],
			[self::uBot1, null, ['ROLE_USER']],
		];
	}
}
