<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229125949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE familiar (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, lastnames VARCHAR(255) DEFAULT NULL, main_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_parents (person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_id INT NOT NULL, INDEX IDX_DFCEAEE3217BBB47 (person_id), UNIQUE INDEX UNIQ_DFCEAEE3727ACA70 (parent_id), PRIMARY KEY(person_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_children (person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', children_id INT NOT NULL, INDEX IDX_35D1148D217BBB47 (person_id), UNIQUE INDEX UNIQ_35D1148D3D3D2749 (children_id), PRIMARY KEY(person_id, children_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_parents ADD CONSTRAINT FK_DFCEAEE3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person_parents ADD CONSTRAINT FK_DFCEAEE3727ACA70 FOREIGN KEY (parent_id) REFERENCES familiar (id)');
        $this->addSql('ALTER TABLE person_children ADD CONSTRAINT FK_35D1148D217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person_children ADD CONSTRAINT FK_35D1148D3D3D2749 FOREIGN KEY (children_id) REFERENCES familiar (id)');
        $this->addSql('DROP TABLE children_parents');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person_parents DROP FOREIGN KEY FK_DFCEAEE3727ACA70');
        $this->addSql('ALTER TABLE person_children DROP FOREIGN KEY FK_35D1148D3D3D2749');
        $this->addSql('CREATE TABLE children_parents (children_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_508E2B13D3D2749 (children_id), INDEX IDX_508E2B1727ACA70 (parent_id), PRIMARY KEY(parent_id, children_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE children_parents ADD CONSTRAINT FK_508E2B13D3D2749 FOREIGN KEY (children_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE children_parents ADD CONSTRAINT FK_508E2B1727ACA70 FOREIGN KEY (parent_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE familiar');
        $this->addSql('DROP TABLE person_parents');
        $this->addSql('DROP TABLE person_children');
    }
}
