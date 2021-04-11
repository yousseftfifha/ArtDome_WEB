<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408225743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation_endroit DROP FOREIGN KEY reservation_endroit_ibfk_1');
        $this->addSql('CREATE TABLE commentaire (id_comment INT AUTO_INCREMENT NOT NULL, id_blog INT DEFAULT NULL, text TEXT NOT NULL, CreatedAt DATE NOT NULL, UpdatedAt DATE NOT NULL, Id_User INT DEFAULT NULL, INDEX fk_idblog (id_blog), INDEX fk_iduser (Id_User), PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, type VARCHAR(50) NOT NULL, UNIQUE INDEX id_user_2 (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservationevent (code_reservation INT AUTO_INCREMENT NOT NULL, code_client INT DEFAULT NULL, code_event INT DEFAULT NULL, nb_place INT NOT NULL, INDEX fk_client (code_client), INDEX fk_event (code_event), PRIMARY KEY(code_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B354D41 FOREIGN KEY (id_blog) REFERENCES blog (idBlog)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6B3CA4B FOREIGN KEY (id_user) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4D7FB13EB FOREIGN KEY (code_event) REFERENCES event (code_event)');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE reservation_endroit');
        $this->addSql('DROP INDEX id_artist ON blog');
        $this->addSql('ALTER TABLE blog ADD Title VARCHAR(100) DEFAULT \',\' NOT NULL, ADD Image LONGTEXT NOT NULL, ADD Description LONGTEXT NOT NULL, ADD Publisher VARCHAR(40) DEFAULT NULL, ADD idBlog INT AUTO_INCREMENT NOT NULL, ADD Categorie INT DEFAULT NULL, DROP blog_id, DROP id_artist, CHANGE date_post DateOfPub DATE NOT NULL, ADD PRIMARY KEY (idBlog)');
        $this->addSql('CREATE INDEX fk_categorie ON blog (Categorie)');
        $this->addSql('CREATE UNIQUE INDEX blog_titres_uindex ON blog (Title)');
        $this->addSql('ALTER TABLE cart MODIFY CartId INT NOT NULL');
        $this->addSql('DROP INDEX OeuvreId ON cart');
        $this->addSql('DROP INDEX id_client ON cart');
        $this->addSql('ALTER TABLE cart DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cart ADD id_user INT DEFAULT NULL, ADD NomOeuvre VARCHAR(30) DEFAULT NULL, DROP id_client, CHANGE cartid IDcart INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX fk_cart ON cart (id_user)');
        $this->addSql('ALTER TABLE cart ADD PRIMARY KEY (IDcart)');
        $this->addSql('ALTER TABLE categorie ADD DateCat DATE DEFAULT NULL, ADD NbreOeuvre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE endroit ADD disponibilite VARCHAR(30) DEFAULT NULL, DROP disponibilité, CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event DROP nb_participant, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE video video VARCHAR(255) DEFAULT NULL, CHANGE code_espace code_espace INT DEFAULT NULL, CHANGE code_artiste code_artiste INT DEFAULT NULL');
        $this->addSql('DROP INDEX code_artiste ON event');
        $this->addSql('CREATE INDEX fk_artiste ON event (code_artiste)');
        $this->addSql('DROP INDEX code_espace ON event');
        $this->addSql('CREATE INDEX fk_espace ON event (code_espace)');
        $this->addSql('DROP INDEX code_oeuvre ON exposition');
        $this->addSql('ALTER TABLE exposition DROP nb_participant, DROP code_oeuvre, CHANGE nom_expo nom_expo VARCHAR(30) NOT NULL, CHANGE theme_expo theme_expo VARCHAR(30) NOT NULL, CHANGE date_expo date_expo DATE NOT NULL, CHANGE nb_max_participant nb_max_participant INT NOT NULL');
        $this->addSql('DROP INDEX code_artiste ON exposition');
        $this->addSql('CREATE INDEX fk_idartiste ON exposition (code_artiste)');
        $this->addSql('DROP INDEX code_espace ON exposition');
        $this->addSql('CREATE INDEX fk_idespace ON exposition (code_espace)');
        $this->addSql('ALTER TABLE oeuvre ADD DateOeuvre DATE DEFAULT NULL, ADD ImageOeuvre VARCHAR(255) NOT NULL, ADD NomCat VARCHAR(50) DEFAULT NULL, ADD EmailArtiste VARCHAR(255) DEFAULT NULL, CHANGE ID_Artiste ID_Artiste INT DEFAULT NULL, CHANGE code_exposition code_exposition INT DEFAULT NULL');
        $this->addSql('DROP INDEX code_exposition ON oeuvre');
        $this->addSql('CREATE INDEX fk_exposition ON oeuvre (code_exposition)');
        $this->addSql('DROP INDEX id_artiste ON oeuvre');
        $this->addSql('CREATE INDEX fk_id ON oeuvre (ID_Artiste)');
        $this->addSql('DROP INDEX AddressId ON orders');
        $this->addSql('ALTER TABLE orders ADD IDUser INT DEFAULT NULL, DROP UserName, DROP AddressId, CHANGE Status Status VARCHAR(30) NOT NULL');
        $this->addSql('CREATE INDEX fk_u ON orders (IDUser)');
        $this->addSql('DROP INDEX AddressID ON pending_orders');
        $this->addSql('DROP INDEX OeuvreID ON pending_orders');
        $this->addSql('ALTER TABLE pending_orders DROP UserName, CHANGE OrderID OrderID INT NOT NULL, CHANGE addressid IDUser INT DEFAULT NULL');
        $this->addSql('CREATE INDEX fk_us ON pending_orders (IDUser)');
        $this->addSql('ALTER TABLE reservation MODIFY code_reservation INT NOT NULL');
        $this->addSql('DROP INDEX code_event ON reservation');
        $this->addSql('DROP INDEX code_client ON reservation');
        $this->addSql('ALTER TABLE reservation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reservation ADD idclient INT NOT NULL, ADD matricule INT NOT NULL, ADD date_debut DATE NOT NULL, ADD date_fin DATE NOT NULL, ADD date_retour VARCHAR(45) DEFAULT NULL, ADD Cautionnement INT NOT NULL, ADD prix_total VARCHAR(45) DEFAULT NULL, DROP code_client, DROP nom_client, DROP prenom_client, DROP telephone, DROP email, DROP nb_place, DROP code_event, CHANGE code_reservation id_reservation INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX _idx ON reservation (idclient)');
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (id_reservation)');
        $this->addSql('DROP INDEX code_client ON reservation_expo');
        $this->addSql('CREATE INDEX fk_clients ON reservation_expo (code_client)');
        $this->addSql('DROP INDEX code_expo ON reservation_expo');
        $this->addSql('CREATE INDEX fk_expo ON reservation_expo (code_expo)');
        $this->addSql('ALTER TABLE user MODIFY id_user INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(30) DEFAULT \'user\', CHANGE mdp mdp VARCHAR(50) DEFAULT NULL, CHANGE id_user ID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (ID)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id_admin INT AUTO_INCREMENT NOT NULL, id_us INT NOT NULL, PRIMARY KEY(id_admin)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (id_client INT AUTO_INCREMENT NOT NULL, id_u INT NOT NULL, INDEX id_u (id_u), PRIMARY KEY(id_client)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forum (forum_id INT NOT NULL, theme VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, user_id INT NOT NULL, reponse TEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX user_id (user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation_endroit (id_reservation INT AUTO_INCREMENT NOT NULL, id_client INT NOT NULL, matricule INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, date_retour DATE NOT NULL, cautionnement INT NOT NULL, prix_total INT NOT NULL, INDEX id_client (id_client), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation_endroit ADD CONSTRAINT reservation_endroit_ibfk_1 FOREIGN KEY (id_client) REFERENCES client (id_u) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE reservationevent');
        $this->addSql('ALTER TABLE blog MODIFY idBlog INT NOT NULL');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143CB8C5497');
        $this->addSql('ALTER TABLE blog DROP PRIMARY KEY');
        $this->addSql('DROP INDEX fk_categorie ON blog');
        $this->addSql('DROP INDEX blog_titres_uindex ON blog');
        $this->addSql('ALTER TABLE blog ADD blog_id INT NOT NULL, ADD id_artist INT NOT NULL, DROP Title, DROP Image, DROP Description, DROP Publisher, DROP idBlog, DROP Categorie, CHANGE dateofpub date_post DATE NOT NULL');
        $this->addSql('CREATE INDEX id_artist ON blog (id_artist)');
        $this->addSql('ALTER TABLE cart MODIFY IDcart INT NOT NULL');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B76B3CA4B');
        $this->addSql('DROP INDEX fk_cart ON cart');
        $this->addSql('ALTER TABLE cart DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cart ADD id_client INT NOT NULL, DROP id_user, DROP NomOeuvre, CHANGE idcart CartId INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX OeuvreId ON cart (OeuvreId)');
        $this->addSql('CREATE INDEX id_client ON cart (id_client)');
        $this->addSql('ALTER TABLE cart ADD PRIMARY KEY (CartId)');
        $this->addSql('ALTER TABLE categorie DROP DateCat, DROP NbreOeuvre');
        $this->addSql('ALTER TABLE endroit ADD disponibilité VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DROP disponibilite, CHANGE location location VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A4A071D3');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7792D51CF');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A4A071D3');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7792D51CF');
        $this->addSql('ALTER TABLE event ADD nb_participant INT DEFAULT NULL, CHANGE code_artiste code_artiste INT NOT NULL, CHANGE code_espace code_espace INT NOT NULL, CHANGE image image VARCHAR(80) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE video video VARCHAR(80) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('DROP INDEX fk_espace ON event');
        $this->addSql('CREATE INDEX code_espace ON event (code_espace)');
        $this->addSql('DROP INDEX fk_artiste ON event');
        $this->addSql('CREATE INDEX code_artiste ON event (code_artiste)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13A4A071D3');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13792D51CF');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13A4A071D3');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13792D51CF');
        $this->addSql('ALTER TABLE exposition ADD nb_participant INT DEFAULT NULL, ADD code_oeuvre INT DEFAULT NULL, CHANGE nom_expo nom_expo VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE theme_expo theme_expo VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date_expo date_expo DATE DEFAULT NULL, CHANGE nb_max_participant nb_max_participant INT DEFAULT NULL');
        $this->addSql('CREATE INDEX code_oeuvre ON exposition (code_oeuvre)');
        $this->addSql('DROP INDEX fk_idartiste ON exposition');
        $this->addSql('CREATE INDEX code_artiste ON exposition (code_artiste)');
        $this->addSql('DROP INDEX fk_idespace ON exposition');
        $this->addSql('CREATE INDEX code_espace ON exposition (code_espace)');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE949F00F5');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE408B24D0');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE949F00F5');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE408B24D0');
        $this->addSql('ALTER TABLE oeuvre DROP DateOeuvre, DROP ImageOeuvre, DROP NomCat, DROP EmailArtiste, CHANGE code_exposition code_exposition INT NOT NULL, CHANGE ID_Artiste ID_Artiste INT NOT NULL');
        $this->addSql('DROP INDEX fk_id ON oeuvre');
        $this->addSql('CREATE INDEX ID_Artiste ON oeuvre (ID_Artiste)');
        $this->addSql('DROP INDEX fk_exposition ON oeuvre');
        $this->addSql('CREATE INDEX code_exposition ON oeuvre (code_exposition)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE949F00F5 FOREIGN KEY (code_exposition) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE408B24D0 FOREIGN KEY (ID_Artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3803A2E5');
        $this->addSql('DROP INDEX fk_u ON orders');
        $this->addSql('ALTER TABLE orders ADD UserName VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD AddressId INT NOT NULL, DROP IDUser, CHANGE Status Status INT NOT NULL');
        $this->addSql('CREATE INDEX AddressId ON orders (AddressId)');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05EEF06D63');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05E3803A2E5');
        $this->addSql('DROP INDEX fk_us ON pending_orders');
        $this->addSql('ALTER TABLE pending_orders ADD UserName VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE OrderID OrderID INT AUTO_INCREMENT NOT NULL, CHANGE iduser AddressID INT DEFAULT NULL');
        $this->addSql('CREATE INDEX AddressID ON pending_orders (AddressID)');
        $this->addSql('CREATE INDEX OeuvreID ON pending_orders (OeuvreID)');
        $this->addSql('ALTER TABLE reservation MODIFY id_reservation INT NOT NULL');
        $this->addSql('DROP INDEX _idx ON reservation');
        $this->addSql('ALTER TABLE reservation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reservation ADD code_client INT DEFAULT NULL, ADD nom_client VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, ADD prenom_client VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, ADD telephone INT DEFAULT NULL, ADD email VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, ADD nb_place INT DEFAULT 0, ADD code_event INT DEFAULT NULL, DROP idclient, DROP matricule, DROP date_debut, DROP date_fin, DROP date_retour, DROP Cautionnement, DROP prix_total, CHANGE id_reservation code_reservation INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX code_event ON reservation (code_event)');
        $this->addSql('CREATE INDEX code_client ON reservation (code_client)');
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (code_reservation)');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B8C25CF7');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B3878E3B');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B8C25CF7');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B3878E3B');
        $this->addSql('DROP INDEX fk_expo ON reservation_expo');
        $this->addSql('CREATE INDEX code_expo ON reservation_expo (code_expo)');
        $this->addSql('DROP INDEX fk_clients ON reservation_expo');
        $this->addSql('CREATE INDEX code_client ON reservation_expo (code_client)');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B3878E3B FOREIGN KEY (code_expo) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE user MODIFY ID INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE mdp mdp VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE id id_user INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id_user)');
    }
}
