<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210211323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parent_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person ADD parent_one_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD parent_two_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD parent_one_type INT NOT NULL, ADD parent_one_string VARCHAR(255) DEFAULT NULL, ADD parent_two_type INT NOT NULL, ADD parent_two_string VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176B4890DD5 FOREIGN KEY (parent_one_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176DFD5EA1A FOREIGN KEY (parent_two_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_34DCD176B4890DD5 ON person (parent_one_id)');
        $this->addSql('CREATE INDEX IDX_34DCD176DFD5EA1A ON person (parent_two_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parent_type');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176B4890DD5');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176DFD5EA1A');
        $this->addSql('DROP INDEX IDX_34DCD176B4890DD5 ON person');
        $this->addSql('DROP INDEX IDX_34DCD176DFD5EA1A ON person');
        $this->addSql('ALTER TABLE person DROP parent_one_id, DROP parent_two_id, DROP parent_one_type, DROP parent_one_string, DROP parent_two_type, DROP parent_two_string');
    }
}
