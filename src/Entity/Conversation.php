<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
#[ApiResource]
class Conversation
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\Column]
	private ?int $nbMessages = null;

	#[ORM\ManyToOne(inversedBy: 'conversationUsers')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $user = null;

	#[ORM\ManyToOne(inversedBy: 'conversationBots')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $bot = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): static
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getNbMessages(): ?int
	{
		return $this->nbMessages;
	}

	public function setNbMessages(int $nbMessages): static
	{
		$this->nbMessages = $nbMessages;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): static
	{
		$this->user = $user;

		return $this;
	}

	public function getBot(): ?User
	{
		return $this->bot;
	}

	public function setBot(?User $bot): static
	{
		$this->bot = $bot;

		return $this;
	}
}
