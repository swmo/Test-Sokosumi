<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260325205019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, max_participants INTEGER NOT NULL, created_at DATETIME NOT NULL, created_by_id INTEGER NOT NULL, CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B03A8386 ON event (created_by_id)');
        $this->addSql('CREATE TABLE registration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, registered_at DATETIME NOT NULL, user_id INTEGER NOT NULL, event_id INTEGER NOT NULL, CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_62A8A7A771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7A76ED395 ON registration (user_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A771F7E88B ON registration (event_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_user_event ON registration (user_id, event_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(30) DEFAULT NULL, roles CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE "user"');
    }
}
