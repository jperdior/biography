<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111105917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, person_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, verified TINYINT(1) NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_CFBDFA14217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE gallery ADD verified TINYINT(1) NOT NULL, ADD approved TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE person ADD allow_notes_or_galleries TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE note');
        $this->addSql('ALTER TABLE gallery DROP verified, DROP approved');
        $this->addSql('ALTER TABLE person DROP allow_notes_or_galleries');
    }
}
