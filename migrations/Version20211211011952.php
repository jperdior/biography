<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211011952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE children_parents (children_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_508E2B13D3D2749 (children_id), INDEX IDX_508E2B1727ACA70 (parent_id), PRIMARY KEY(children_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE children_parents ADD CONSTRAINT FK_508E2B13D3D2749 FOREIGN KEY (children_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE children_parents ADD CONSTRAINT FK_508E2B1727ACA70 FOREIGN KEY (parent_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person ADD partner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP parent_one_type, DROP parent_one_string, DROP parent_two_type, DROP parent_two_string');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1769393F8FE FOREIGN KEY (partner_id) REFERENCES person (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD1769393F8FE ON person (partner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE children_parents');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1769393F8FE');
        $this->addSql('DROP INDEX UNIQ_34DCD1769393F8FE ON person');
        $this->addSql('ALTER TABLE person ADD parent_one_type INT DEFAULT NULL, ADD parent_one_string VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD parent_two_type INT DEFAULT NULL, ADD parent_two_string VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, DROP partner_id');
    }
}
