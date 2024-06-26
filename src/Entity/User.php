<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource]
#[ApiFilter(OrderFilter::class)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 180)]
	private ?string $username = null;

	/**
	 * @var list<string> The user roles
	 */
	#[ORM\Column]
	private array $roles = [];

	/**
	 * @var string The hashed password
	 */
	#[ORM\Column]
	private ?string $password = null;

	/**
	 * @var Collection<int, Conversation>
	 */
	#[ORM\OneToMany(targetEntity: Conversation::class, mappedBy: 'user', orphanRemoval: true)]
	private Collection $conversationUsers;

	/**
	 * @var Collection<int, Conversation>
	 */
	#[ORM\OneToMany(targetEntity: Conversation::class, mappedBy: 'bot', orphanRemoval: true)]
	private Collection $conversationBots;

	public function __construct()
	{
		$this->conversationUsers = new ArrayCollection();
		$this->conversationBots = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(string $username): static
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string) $this->username;
	}

	/**
	 * @see UserInterface
	 *
	 * @return list<string>
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	/**
	 * @param list<string> $roles
	 */
	public function setRoles(array $roles): static
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->password ?? '';
	}

	public function setPassword(string $password): static
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

	/**
	 * @return Collection<int, Conversation>
	 */
	public function getConversationUsers(): Collection
	{
		return $this->conversationUsers;
	}

	public function addConversationUser(Conversation $conversationUser): static
	{
		if (!$this->conversationUsers->contains($conversationUser)) {
			$this->conversationUsers->add($conversationUser);
			$conversationUser->setUser($this);
		}

		return $this;
	}

	public function removeConversationUser(Conversation $conversationUser): static
	{
		if ($this->conversationUsers->removeElement($conversationUser)) {
			// set the owning side to null (unless already changed)
			if ($conversationUser->getUser() === $this) {
				$conversationUser->setUser(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, Conversation>
	 */
	public function getConversationBots(): Collection
	{
		return $this->conversationBots;
	}

	public function addConversationBot(Conversation $conversationBot): static
	{
		if (!$this->conversationBots->contains($conversationBot)) {
			$this->conversationBots->add($conversationBot);
			$conversationBot->setBot($this);
		}

		return $this;
	}

	public function removeConversationBot(Conversation $conversationBot): static
	{
		if ($this->conversationBots->removeElement($conversationBot)) {
			// set the owning side to null (unless already changed)
			if ($conversationBot->getBot() === $this) {
				$conversationBot->setBot(null);
			}
		}

		return $this;
	}
}
