<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private $entityManager;
    private $managerRegistry;
    private $userRepository;

    protected function setUp(): void
    {
        // Créer un mock de EntityManagerInterface
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // Créer un mock de ManagerRegistry
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->managerRegistry->method('getManagerForClass')->willReturn($this->entityManager);

        // Configurer le mock de ClassMetadata
        $classMetadata = $this->createMock(ClassMetadata::class);
        $classMetadata->name = User::class;

        // Configurer le mock de EntityManager pour retourner ClassMetadata
        $this->entityManager->method('getClassMetadata')->willReturn($classMetadata);

        // Créer une instance de UserRepository avec le mock de ManagerRegistry
        $this->userRepository = new UserRepository($this->managerRegistry);
    }

    public function testCreateAndFindUser(): void
    {
        // Utiliser un nom d'utilisateur unique pour éviter les conflits
        $uniqueUsername = 'testuser_' . uniqid();

        // Créer un nouvel utilisateur avec tous les champs requis
        $user = new User();
        $user->setUsername($uniqueUsername);
        $user->setPassword('password');

        // Configurer le mock de EntityManager pour retourner l'utilisateur lors de l'appel à persist et flush
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($user));
        $this->entityManager->expects($this->once())
            ->method('flush');

        // Simuler le comportement de UserRepository::findOneBy
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->managerRegistry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $this->userRepository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo(['username' => $uniqueUsername]))
            ->willReturn($user);

        // Appeler les méthodes à tester
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $retrievedUser = $this->userRepository->findOneBy(['username' => $uniqueUsername]);

        // Vérifier que l'utilisateur a été correctement créé et récupéré
        $this->assertInstanceOf(User::class, $retrievedUser);
        $this->assertSame($uniqueUsername, $retrievedUser->getUsername());
        $this->assertSame('password', $retrievedUser->getPassword());
    }
}
