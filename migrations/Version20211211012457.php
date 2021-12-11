<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211012457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176C35E566A');
        $this->addSql('DROP INDEX IDX_34DCD176C35E566A ON person');
        $this->addSql('ALTER TABLE person DROP family_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD family_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_34DCD176C35E566A ON person (family_id)');
    }
}
