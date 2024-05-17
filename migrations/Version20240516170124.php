<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516170124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD user_id_id INT NOT NULL, ADD bot_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E99D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9C1CE28CB FOREIGN KEY (bot_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E99D86650F ON conversation (user_id_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9C1CE28CB ON conversation (bot_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E99D86650F');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9C1CE28CB');
        $this->addSql('DROP INDEX IDX_8A8E26E99D86650F ON conversation');
        $this->addSql('DROP INDEX IDX_8A8E26E9C1CE28CB ON conversation');
        $this->addSql('ALTER TABLE conversation DROP user_id_id, DROP bot_id_id');
    }
}
