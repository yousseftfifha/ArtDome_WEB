<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427224904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expo_oeuvre ADD code_oeuvre INT DEFAULT NULL, ADD code_expo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expo_oeuvre ADD CONSTRAINT FK_753293B4A78765C FOREIGN KEY (code_oeuvre) REFERENCES oeuvre (ID_Oeuvre)');
        $this->addSql('ALTER TABLE expo_oeuvre ADD CONSTRAINT FK_753293BB3878E3B FOREIGN KEY (code_expo) REFERENCES exposition (code_expo)');
        $this->addSql('CREATE INDEX IDX_753293B4A78765C ON expo_oeuvre (code_oeuvre)');
        $this->addSql('CREATE INDEX IDX_753293BB3878E3B ON expo_oeuvre (code_expo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expo_oeuvre DROP FOREIGN KEY FK_753293B4A78765C');
        $this->addSql('ALTER TABLE expo_oeuvre DROP FOREIGN KEY FK_753293BB3878E3B');
        $this->addSql('DROP INDEX IDX_753293B4A78765C ON expo_oeuvre');
        $this->addSql('DROP INDEX IDX_753293BB3878E3B ON expo_oeuvre');
        $this->addSql('ALTER TABLE expo_oeuvre DROP code_oeuvre, DROP code_expo');
    }
}
