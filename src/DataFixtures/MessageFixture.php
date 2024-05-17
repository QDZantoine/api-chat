<?php

namespace App\DataFixtures;

use App\Entity\Conversation;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixture extends Fixture implements DependentFixtureInterface
{
	public function __construct(private readonly string $projectDir)
	{
	}

	public function getDependencies()
	{
		return [
			ConversationFixture::class,
		];
	}

	public function load(ObjectManager $manager): void
	{
		foreach ($this->getMessageData() as [$createdAt, $text, $userKind,$conversation]) {
			$entity = new Message();
			$entity->setCreatedAt(new \DateTimeImmutable($createdAt));
			$entity->setText($text);
			$entity->setUserKind($userKind);
			$conversation = $this->getReference(Conversation::class.$conversation, Conversation::class);
			$entity->setConversation($conversation);
			$manager->persist($entity);
		}

		$manager->flush();
	}

	private function getMessageData(): array
	{
		$filePath = sprintf('%s/data/messages.csv', $this->projectDir);

		if (($handle = fopen($filePath, 'r')) === false) {
			throw new \Exception('Unable to open file: '.$filePath);
		}

		$res = [];
		while (($data = fgetcsv($handle, null, "\t")) !== false) {
			// Remove unused first column = id
			array_shift($data);
			$res[] = $data;
		}
		fclose($handle);

		return $res;
	}
}
