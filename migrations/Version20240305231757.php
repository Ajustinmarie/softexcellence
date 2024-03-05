<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305231757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil_vba ADD themes_id INT NOT NULL');
        $this->addSql('ALTER TABLE outil_vba ADD CONSTRAINT FK_4411A63494F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id)');
        $this->addSql('CREATE INDEX IDX_4411A63494F4A9D2 ON outil_vba (themes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil_vba DROP FOREIGN KEY FK_4411A63494F4A9D2');
        $this->addSql('DROP INDEX IDX_4411A63494F4A9D2 ON outil_vba');
        $this->addSql('ALTER TABLE outil_vba DROP themes_id');
    }
}
