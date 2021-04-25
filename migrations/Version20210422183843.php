<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422183843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog RENAME INDEX fk_c0155143cb8c5497 TO fk_categorie');
        $this->addSql('ALTER TABLE cart RENAME INDEX fk_ba388b78522d5a6 TO fk_oeuvre');
        $this->addSql('ALTER TABLE cart RENAME INDEX fk_ba388b76b3ca4b TO fk_cart');
        $this->addSql('ALTER TABLE commentaire RENAME INDEX fk_67f068bc4b354d41 TO fk_idblog');
        $this->addSql('ALTER TABLE commentaire RENAME INDEX fk_67f068bc693c5ce9 TO fk_iduser');
        $this->addSql('ALTER TABLE event RENAME INDEX fk_3bae0aa7a4a071d3 TO fk_artiste');
        $this->addSql('ALTER TABLE event RENAME INDEX fk_3bae0aa7792d51cf TO fk_espace');
        $this->addSql('ALTER TABLE exposition RENAME INDEX fk_bc31fd13a4a071d3 TO fk_idartiste');
        $this->addSql('ALTER TABLE exposition RENAME INDEX fk_bc31fd13792d51cf TO fk_idespace');
        $this->addSql('ALTER TABLE oeuvre RENAME INDEX fk_35fe2efe949f00f5 TO fk_exposition');
        $this->addSql('ALTER TABLE oeuvre RENAME INDEX fk_35fe2efe408b24d0 TO fk_id');
        $this->addSql('ALTER TABLE orders RENAME INDEX fk_e52ffdee3803a2e5 TO fk_u');
        $this->addSql('ALTER TABLE pending_orders ADD Status VARCHAR(30) DEFAULT \'Pending\'');
        $this->addSql('ALTER TABLE pending_orders RENAME INDEX fk_eb6be05ebe4cf56e TO fk_oeuvres');
        $this->addSql('ALTER TABLE pending_orders RENAME INDEX fk_eb6be05e3803a2e5 TO fk_us');
        $this->addSql('ALTER TABLE reservation_expo RENAME INDEX fk_93552992b8c25cf7 TO fk_clients');
        $this->addSql('ALTER TABLE reservation_expo RENAME INDEX fk_93552992b3878e3b TO fk_expo');
        $this->addSql('ALTER TABLE reservationevent RENAME INDEX fk_70b2b7d4b8c25cf7 TO fk_client');
        $this->addSql('ALTER TABLE reservationevent RENAME INDEX fk_70b2b7d4d7fb13eb TO fk_event');
        $this->addSql('ALTER TABLE user ADD sexe VARCHAR(255) DEFAULT NULL, ADD roles JSON NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP role, CHANGE mdp password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog RENAME INDEX fk_categorie TO FK_C0155143CB8C5497');
        $this->addSql('ALTER TABLE cart RENAME INDEX fk_oeuvre TO FK_BA388B78522D5A6');
        $this->addSql('ALTER TABLE cart RENAME INDEX fk_cart TO FK_BA388B76B3CA4B');
        $this->addSql('ALTER TABLE commentaire RENAME INDEX fk_iduser TO FK_67F068BC693C5CE9');
        $this->addSql('ALTER TABLE commentaire RENAME INDEX fk_idblog TO FK_67F068BC4B354D41');
        $this->addSql('ALTER TABLE event RENAME INDEX fk_espace TO FK_3BAE0AA7792D51CF');
        $this->addSql('ALTER TABLE event RENAME INDEX fk_artiste TO FK_3BAE0AA7A4A071D3');
        $this->addSql('ALTER TABLE exposition RENAME INDEX fk_idespace TO FK_BC31FD13792D51CF');
        $this->addSql('ALTER TABLE exposition RENAME INDEX fk_idartiste TO FK_BC31FD13A4A071D3');
        $this->addSql('ALTER TABLE oeuvre RENAME INDEX fk_id TO FK_35FE2EFE408B24D0');
        $this->addSql('ALTER TABLE oeuvre RENAME INDEX fk_exposition TO FK_35FE2EFE949F00F5');
        $this->addSql('ALTER TABLE orders RENAME INDEX fk_u TO FK_E52FFDEE3803A2E5');
        $this->addSql('ALTER TABLE pending_orders DROP Status');
        $this->addSql('ALTER TABLE pending_orders RENAME INDEX fk_us TO FK_EB6BE05E3803A2E5');
        $this->addSql('ALTER TABLE pending_orders RENAME INDEX fk_oeuvres TO FK_EB6BE05EBE4CF56E');
        $this->addSql('ALTER TABLE reservation_expo RENAME INDEX fk_expo TO FK_93552992B3878E3B');
        $this->addSql('ALTER TABLE reservation_expo RENAME INDEX fk_clients TO FK_93552992B8C25CF7');
        $this->addSql('ALTER TABLE reservationevent RENAME INDEX fk_event TO FK_70B2B7D4D7FB13EB');
        $this->addSql('ALTER TABLE reservationevent RENAME INDEX fk_client TO FK_70B2B7D4B8C25CF7');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(30) CHARACTER SET latin1 DEFAULT \'user\' NOT NULL COLLATE `latin1_swedish_ci`, DROP sexe, DROP roles, DROP is_verified, CHANGE password mdp VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
