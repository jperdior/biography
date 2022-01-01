<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229143815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE person_children');
        $this->addSql('DROP TABLE person_parents');
        $this->addSql('ALTER TABLE familiar ADD child_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EDD62C21B FOREIGN KEY (child_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E727ACA70 FOREIGN KEY (parent_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5EDD62C21B ON familiar (child_id)');
        $this->addSql('CREATE INDEX IDX_8A34CA5E727ACA70 ON familiar (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person_children (person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', children_id INT NOT NULL, INDEX IDX_35D1148D217BBB47 (person_id), UNIQUE INDEX UNIQ_35D1148D3D3D2749 (children_id), PRIMARY KEY(person_id, children_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE person_parents (person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_id INT NOT NULL, INDEX IDX_DFCEAEE3217BBB47 (person_id), UNIQUE INDEX UNIQ_DFCEAEE3727ACA70 (parent_id), PRIMARY KEY(person_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE person_children ADD CONSTRAINT FK_35D1148D217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_children ADD CONSTRAINT FK_35D1148D3D3D2749 FOREIGN KEY (children_id) REFERENCES familiar (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_parents ADD CONSTRAINT FK_DFCEAEE3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_parents ADD CONSTRAINT FK_DFCEAEE3727ACA70 FOREIGN KEY (parent_id) REFERENCES familiar (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EDD62C21B');
        $this->addSql('ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E727ACA70');
        $this->addSql('DROP INDEX IDX_8A34CA5EDD62C21B ON familiar');
        $this->addSql('DROP INDEX IDX_8A34CA5E727ACA70 ON familiar');
        $this->addSql('ALTER TABLE familiar DROP child_id, DROP parent_id');
    }
}
