<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427223827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE expo_oeuvre');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE expo_oeuvre (id_expo_oeuvre INT AUTO_INCREMENT NOT NULL, code_oeuvre INT NOT NULL, code_expo INT NOT NULL, INDEX fkExpo (code_expo), INDEX fkOeuvre (code_oeuvre), PRIMARY KEY(id_expo_oeuvre)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE expo_oeuvre ADD CONSTRAINT fkExpo FOREIGN KEY (code_expo) REFERENCES exposition (code_expo) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expo_oeuvre ADD CONSTRAINT fkOeuvre FOREIGN KEY (code_oeuvre) REFERENCES oeuvre (ID_Oeuvre) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
