<?php

namespace App\DataFixtures;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConversationFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [
			UserFixture::class,
		];
	}

	public function load(ObjectManager $manager): void
	{
		$count = 0;
		foreach ($this->getConversationdata() as [$createdAt, $nbMessages,$user,$bot]) {
			$userRef = $this->getReference(User::class.$user, User::class);
			$botRef = $this->getReference(User::class.$bot, User::class);
			$entity = new Conversation();
			$entity->setCreatedAt(new \DateTimeImmutable($createdAt));
			$entity->setNbMessages($nbMessages);
			$entity->setUser($userRef);
			$entity->setBot($botRef);
			$manager->persist($entity);
			$this->addReference(Conversation::class.++$count, $entity);
		}

		$manager->flush();
	}

	private function getConversationdata(): array
	{
		return [
			['2024-05-01 08:00:00', 15, 1, 4],
			['2024-05-01 09:30:00', 10, 2, 4],
			['2024-05-01 11:00:00', 8, 3, 4],
			['2024-05-01 12:30:00', 20, 1, 4],
			['2024-05-01 14:00:00', 12, 2, 4],
			['2024-05-01 15:30:00', 6, 3, 4],
			['2024-05-01 17:00:00', 14, 1, 4],
			['2024-05-01 18:30:00', 9, 2, 4],
			['2024-05-01 20:00:00', 11, 3, 4],
			['2024-05-01 21:30:00', 7, 1, 4],
			['2024-05-01 08:15:00', 10, 2, 4],
			['2024-05-01 09:45:00', 12, 1, 4],
			['2024-05-01 11:15:00', 14, 3, 4],
			['2024-05-01 12:45:00', 16, 2, 4],
			['2024-05-01 14:15:00', 18, 1, 4],
			['2024-05-01 15:45:00', 11, 3, 4],
			['2024-05-01 17:15:00', 9, 2, 4],
			['2024-05-01 18:45:00', 13, 1, 4],
			['2024-05-01 20:15:00', 8, 3, 4],
			['2024-05-01 21:45:00', 7, 2, 4],
			['2024-05-02 08:00:00', 19, 1, 4],
			['2024-05-02 09:30:00', 10, 3, 4],
			['2024-05-02 11:00:00', 14, 2, 4],
			['2024-05-02 12:30:00', 6, 1, 4],
			['2024-05-02 14:00:00', 12, 3, 4],
		];
	}
}
