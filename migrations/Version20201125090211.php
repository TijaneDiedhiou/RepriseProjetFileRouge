<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125090211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence_groupe_competence DROP FOREIGN KEY FK_8A72A47315761DAB');
        $this->addSql('ALTER TABLE competence_groupe_competence DROP FOREIGN KEY FK_8A72A47389034830');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_groupe_competence');
        $this->addSql('DROP TABLE groupe_competence');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE competence_groupe_competence (competence_id INT NOT NULL, groupe_competence_id INT NOT NULL, INDEX IDX_8A72A47315761DAB (competence_id), INDEX IDX_8A72A47389034830 (groupe_competence_id), PRIMARY KEY(competence_id, groupe_competence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe_competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, descriptif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE competence_groupe_competence ADD CONSTRAINT FK_8A72A47315761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_groupe_competence ADD CONSTRAINT FK_8A72A47389034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
