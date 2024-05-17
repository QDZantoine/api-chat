<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516170550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9C1CE28CB');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E99D86650F');
        $this->addSql('DROP INDEX IDX_8A8E26E99D86650F ON conversation');
        $this->addSql('DROP INDEX IDX_8A8E26E9C1CE28CB ON conversation');
        $this->addSql('ALTER TABLE conversation ADD user_id INT NOT NULL, ADD bot_id INT NOT NULL, DROP user_id_id, DROP bot_id_id');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E992C1C487 FOREIGN KEY (bot_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9A76ED395 ON conversation (user_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E992C1C487 ON conversation (bot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9A76ED395');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E992C1C487');
        $this->addSql('DROP INDEX IDX_8A8E26E9A76ED395 ON conversation');
        $this->addSql('DROP INDEX IDX_8A8E26E992C1C487 ON conversation');
        $this->addSql('ALTER TABLE conversation ADD user_id_id INT NOT NULL, ADD bot_id_id INT NOT NULL, DROP user_id, DROP bot_id');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9C1CE28CB FOREIGN KEY (bot_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E99D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E99D86650F ON conversation (user_id_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9C1CE28CB ON conversation (bot_id_id)');
    }
}
