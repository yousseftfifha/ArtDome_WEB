<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422185013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY fk_categorie');
        $this->addSql('ALTER TABLE blog CHANGE Categorie Categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143CB8C5497 FOREIGN KEY (Categorie) REFERENCES categorie (ID_Cat)');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY fk_cart');
        $this->addSql('ALTER TABLE cart DROP NomOeuvre, CHANGE id_user id_user INT DEFAULT NULL, CHANGE OeuvreId OeuvreId INT DEFAULT NULL, CHANGE Quantity Quantity INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B76B3CA4B FOREIGN KEY (id_user) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B78522D5A6 FOREIGN KEY (OeuvreId) REFERENCES oeuvre (ID_Oeuvre)');
        $this->addSql('CREATE INDEX fk_oeuvre ON cart (OeuvreId)');
        $this->addSql('ALTER TABLE categorie CHANGE NbreOeuvre NbreOeuvre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_idblog');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_iduser');
        $this->addSql('ALTER TABLE commentaire CHANGE id_comment id_comment INT AUTO_INCREMENT NOT NULL, CHANGE id_blog id_blog INT DEFAULT NULL, CHANGE Id_User Id_User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B354D41 FOREIGN KEY (id_blog) REFERENCES blog (idBlog)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY fk_artiste');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY fk_espace');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY fk_idartiste');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY fk_idespace');
        $this->addSql('ALTER TABLE exposition CHANGE code_espace code_espace INT DEFAULT NULL, CHANGE code_artiste code_artiste INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY fk_user');
        $this->addSql('DROP INDEX id_user ON notification');
        $this->addSql('ALTER TABLE notification CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6B3CA4B FOREIGN KEY (id_user) REFERENCES user (ID)');
        $this->addSql('CREATE INDEX id_user ON notification (ID)');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY fk_exposition');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY fk_id');
        $this->addSql('ALTER TABLE oeuvre CHANGE ID_Artiste ID_Artiste INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE949F00F5 FOREIGN KEY (code_exposition) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE408B24D0 FOREIGN KEY (ID_Artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY fk_u');
        $this->addSql('ALTER TABLE orders DROP TotalQty, CHANGE OrderID OrderID INT AUTO_INCREMENT NOT NULL, CHANGE IDUser IDUser INT DEFAULT NULL, CHANGE OrderDate OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3803A2E5 FOREIGN KEY (IDUser) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY fk_order');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY fk_us');
        $this->addSql('ALTER TABLE pending_orders DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE pending_orders ADD ID_PendingOrder INT AUTO_INCREMENT NOT NULL, DROP OrderID, CHANGE Status Status VARCHAR(30) DEFAULT \'Pending\'');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT FK_EB6BE05EBE4CF56E FOREIGN KEY (OeuvreID) REFERENCES oeuvre (ID_Oeuvre)');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT FK_EB6BE05E3803A2E5 FOREIGN KEY (IDUser) REFERENCES user (ID)');
        $this->addSql('CREATE INDEX fk_oeuvres ON pending_orders (OeuvreID)');
        $this->addSql('ALTER TABLE pending_orders ADD PRIMARY KEY (ID_PendingOrder)');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY fk_clients');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY fk_expo');
        $this->addSql('ALTER TABLE reservation_expo CHANGE code_expo code_expo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B3878E3B FOREIGN KEY (code_expo) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY fk_client');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY fk_event');
        $this->addSql('ALTER TABLE reservationevent CHANGE code_event code_event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4D7FB13EB FOREIGN KEY (code_event) REFERENCES event (code_event)');
        $this->addSql('ALTER TABLE user ADD sexe VARCHAR(255) DEFAULT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP role, DROP mdp, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143CB8C5497');
        $this->addSql('ALTER TABLE blog CHANGE Categorie Categorie INT NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT fk_categorie FOREIGN KEY (Categorie) REFERENCES categorie (ID_Cat) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B76B3CA4B');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B78522D5A6');
        $this->addSql('DROP INDEX fk_oeuvre ON cart');
        $this->addSql('ALTER TABLE cart ADD NomOeuvre VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE id_user id_user INT NOT NULL, CHANGE Quantity Quantity INT NOT NULL, CHANGE OeuvreId OeuvreId INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT fk_cart FOREIGN KEY (id_user) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie CHANGE NbreOeuvre NbreOeuvre INT DEFAULT 0');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4B354D41');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC693C5CE9');
        $this->addSql('ALTER TABLE commentaire CHANGE id_comment id_comment INT NOT NULL, CHANGE id_blog id_blog INT NOT NULL, CHANGE Id_User Id_User INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_idblog FOREIGN KEY (id_blog) REFERENCES blog (idBlog) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_iduser FOREIGN KEY (Id_User) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A4A071D3');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7792D51CF');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_artiste FOREIGN KEY (code_artiste) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_espace FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13A4A071D3');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13792D51CF');
        $this->addSql('ALTER TABLE exposition CHANGE code_artiste code_artiste INT NOT NULL, CHANGE code_espace code_espace INT NOT NULL');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT fk_idartiste FOREIGN KEY (code_artiste) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT fk_idespace FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA6B3CA4B');
        $this->addSql('DROP INDEX id_user ON notification');
        $this->addSql('ALTER TABLE notification CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES user (ID) ON UPDATE CASCADE');
        $this->addSql('CREATE INDEX id_user ON notification (id_user)');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE949F00F5');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE408B24D0');
        $this->addSql('ALTER TABLE oeuvre CHANGE ID_Artiste ID_Artiste INT NOT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT fk_exposition FOREIGN KEY (code_exposition) REFERENCES exposition (code_expo) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT fk_id FOREIGN KEY (ID_Artiste) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3803A2E5');
        $this->addSql('ALTER TABLE orders ADD TotalQty INT NOT NULL, CHANGE OrderID OrderID INT NOT NULL, CHANGE OrderDate OrderDate VARCHAR(70) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE IDUser IDUser INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT fk_u FOREIGN KEY (IDUser) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pending_orders MODIFY ID_PendingOrder INT NOT NULL');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05EBE4CF56E');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05E3803A2E5');
        $this->addSql('DROP INDEX fk_oeuvres ON pending_orders');
        $this->addSql('ALTER TABLE pending_orders DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE pending_orders ADD OrderID INT NOT NULL, DROP ID_PendingOrder, CHANGE Status Status VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT fk_order FOREIGN KEY (OrderID) REFERENCES orders (OrderID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT fk_us FOREIGN KEY (IDUser) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pending_orders ADD PRIMARY KEY (OrderID)');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B8C25CF7');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B3878E3B');
        $this->addSql('ALTER TABLE reservation_expo CHANGE code_expo code_expo INT NOT NULL');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT fk_clients FOREIGN KEY (code_client) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT fk_expo FOREIGN KEY (code_expo) REFERENCES exposition (code_expo) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D4B8C25CF7');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D4D7FB13EB');
        $this->addSql('ALTER TABLE reservationevent CHANGE code_event code_event INT NOT NULL');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT fk_client FOREIGN KEY (code_client) REFERENCES user (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT fk_event FOREIGN KEY (code_event) REFERENCES event (code_event) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(30) CHARACTER SET latin1 DEFAULT \'user\' COLLATE `latin1_swedish_ci`, ADD mdp VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, DROP sexe, DROP roles, DROP password, DROP is_verified, CHANGE nom nom VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
