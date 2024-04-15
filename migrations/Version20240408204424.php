<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408204424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE outil_web (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, descriptif LONGTEXT NOT NULL, lien_video VARCHAR(255) DEFAULT NULL, user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE themes ADD outil_web_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE themes ADD CONSTRAINT FK_154232DEBC0713FE FOREIGN KEY (outil_web_id) REFERENCES outil_web (id)');
        $this->addSql('CREATE INDEX IDX_154232DEBC0713FE ON themes (outil_web_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE themes DROP FOREIGN KEY FK_154232DEBC0713FE');
        $this->addSql('DROP TABLE outil_web');
        $this->addSql('DROP INDEX IDX_154232DEBC0713FE ON themes');
        $this->addSql('ALTER TABLE themes DROP outil_web_id');
    }
}
