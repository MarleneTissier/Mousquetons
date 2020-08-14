<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812131510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FDA6A219 FOREIGN KEY (place_id) REFERENCES places (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FDA6A219 ON discussion (place_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FDA6A219');
        $this->addSql('DROP INDEX IDX_C0B9F90FDA6A219 ON discussion');
    }
}
