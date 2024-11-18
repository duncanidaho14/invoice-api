<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118001449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09CCFA12B8 FOREIGN KEY (profile_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_81398E09CCFA12B8 ON customer (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09CCFA12B8');
        $this->addSql('DROP INDEX IDX_81398E09CCFA12B8');
        $this->addSql('ALTER TABLE customer DROP profile_id');
    }
}
