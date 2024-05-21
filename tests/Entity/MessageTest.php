<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use App\Entity\Conversation;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testMessageCreation()
    {
        $message = new Message();
        
        $this->assertNull($message->getId());
        $this->assertNull($message->getCreatedAt());
        $this->assertNull($message->getText());
        $this->assertNull($message->getConversation());
        $this->assertNull($message->getUserKind());
    }

    public function testSetAndGetCreatedAt()
    {
        $message = new Message();
        $dateTime = new \DateTimeImmutable();
        
        $message->setCreatedAt($dateTime);
        
        $this->assertSame($dateTime, $message->getCreatedAt());
    }

    public function testSetAndGetText()
    {
        $message = new Message();
        $text = "Hello, this is a test message.";
        
        $message->setText($text);
        
        $this->assertSame($text, $message->getText());
    }

    public function testSetAndGetConversation()
    {
        $message = new Message();
        $conversation = new Conversation();
        
        $message->setConversation($conversation);
        
        $this->assertSame($conversation, $message->getConversation());
    }

    public function testSetAndGetUserKind()
    {
        $message = new Message();
        $userKind = 1;
        
        $message->setUserKind($userKind);
        
        $this->assertSame($userKind, $message->getUserKind());
    }
}
