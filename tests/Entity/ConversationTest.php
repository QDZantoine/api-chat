<?php

namespace App\Tests\Entity;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ConversationTest extends TestCase
{
    public function testConversationCreation()
    {
        $conversation = new Conversation();
        
        $this->assertInstanceOf(\DateTimeImmutable::class, $conversation->getCreatedAt());
        $this->assertEquals(0, $conversation->getNbMessages());
        $this->assertEmpty($conversation->getMessages());
    }

    public function testSetAndGetUser()
    {
        $conversation = new Conversation();
        $user = new User();

        $conversation->setUser($user);
        
        $this->assertSame($user, $conversation->getUser());
    }

    public function testSetAndGetBot()
    {
        $conversation = new Conversation();
        $bot = new User();

        $conversation->setBot($bot);
        
        $this->assertSame($bot, $conversation->getBot());
    }

    public function testAddAndRemoveMessage()
    {
        $conversation = new Conversation();
        $message = new Message();
        
        $conversation->addMessage($message);
        
        $this->assertCount(1, $conversation->getMessages());
        $this->assertSame($message, $conversation->getMessages()->first());
        $this->assertSame($conversation, $message->getConversation());

        $conversation->removeMessage($message);
        
        $this->assertCount(0, $conversation->getMessages());
        $this->assertNull($message->getConversation());
    }
}
