<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422183355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (Title VARCHAR(100) DEFAULT \',\' NOT NULL, DateOfPub DATE NOT NULL, Image LONGTEXT NOT NULL, Description LONGTEXT NOT NULL, Publisher VARCHAR(40) DEFAULT NULL, idBlog INT AUTO_INCREMENT NOT NULL, Categorie INT DEFAULT NULL, INDEX fk_categorie (Categorie), UNIQUE INDEX blog_titres_uindex (Title), PRIMARY KEY(idBlog)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id_user INT DEFAULT NULL, IDcart INT AUTO_INCREMENT NOT NULL, Quantity INT DEFAULT 1 NOT NULL, OeuvreId INT DEFAULT NULL, INDEX fk_oeuvre (OeuvreId), INDEX fk_cart (id_user), PRIMARY KEY(IDcart)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (ID_Cat INT AUTO_INCREMENT NOT NULL, Type VARCHAR(30) NOT NULL, Description TEXT NOT NULL, NomCat VARCHAR(40) NOT NULL, DateCat DATE DEFAULT NULL, NbreOeuvre INT DEFAULT NULL, PRIMARY KEY(ID_Cat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id_comment INT AUTO_INCREMENT NOT NULL, id_blog INT DEFAULT NULL, text TEXT NOT NULL, CreatedAt DATE NOT NULL, UpdatedAt DATE NOT NULL, Id_User INT DEFAULT NULL, INDEX fk_idblog (id_blog), INDEX fk_iduser (Id_User), PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE endroit (id_endroit INT AUTO_INCREMENT NOT NULL, type VARCHAR(30) NOT NULL, taille INT NOT NULL, prix_jour INT NOT NULL, nbrch INT NOT NULL, location VARCHAR(255) DEFAULT NULL, disponibilite VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id_endroit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (code_event INT AUTO_INCREMENT NOT NULL, code_artiste INT DEFAULT NULL, code_espace INT DEFAULT NULL, nom_event VARCHAR(30) NOT NULL, theme_event VARCHAR(30) NOT NULL, etat VARCHAR(50) NOT NULL, date DATE NOT NULL, nb_max_part INT NOT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, INDEX fk_artiste (code_artiste), INDEX fk_espace (code_espace), PRIMARY KEY(code_event)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exposition (code_expo INT AUTO_INCREMENT NOT NULL, code_artiste INT DEFAULT NULL, code_espace INT DEFAULT NULL, nom_expo VARCHAR(30) NOT NULL, theme_expo VARCHAR(30) NOT NULL, date_expo DATE NOT NULL, nb_max_participant INT NOT NULL, INDEX fk_idartiste (code_artiste), INDEX fk_idespace (code_espace), PRIMARY KEY(code_expo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, type VARCHAR(50) NOT NULL, INDEX id_user (ID), UNIQUE INDEX id_user_2 (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre (code_exposition INT DEFAULT NULL, ID_Oeuvre INT AUTO_INCREMENT NOT NULL, NomOeuvre VARCHAR(30) NOT NULL, PrixOeuvre DOUBLE PRECISION NOT NULL, DateOeuvre DATE DEFAULT NULL, ImageOeuvre VARCHAR(255) NOT NULL, NomCat VARCHAR(50) DEFAULT NULL, EmailArtiste VARCHAR(255) DEFAULT NULL, ID_Artiste INT DEFAULT NULL, INDEX fk_exposition (code_exposition), INDEX fk_id (ID_Artiste), PRIMARY KEY(ID_Oeuvre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (OrderID INT AUTO_INCREMENT NOT NULL, DueAmount DOUBLE PRECISION NOT NULL, InnoNumber INT NOT NULL, OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, Status VARCHAR(30) NOT NULL, IDUser INT DEFAULT NULL, INDEX fk_u (IDUser), PRIMARY KEY(OrderID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pending_orders (ID_PendingOrder INT AUTO_INCREMENT NOT NULL, InnoNumber INT DEFAULT NULL, Quantity INT DEFAULT NULL, Status VARCHAR(30) DEFAULT \'Pending\', OeuvreID INT DEFAULT NULL, IDUser INT DEFAULT NULL, INDEX fk_oeuvres (OeuvreID), INDEX fk_us (IDUser), PRIMARY KEY(ID_PendingOrder)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id_reservation INT AUTO_INCREMENT NOT NULL, idclient INT NOT NULL, matricule INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, date_retour VARCHAR(45) DEFAULT NULL, Cautionnement INT NOT NULL, prix_total VARCHAR(45) DEFAULT NULL, INDEX _idx (idclient), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_expo (code_client INT DEFAULT NULL, code_expo INT DEFAULT NULL, code_reservationE INT AUTO_INCREMENT NOT NULL, nb_place INT DEFAULT NULL, INDEX fk_clients (code_client), INDEX fk_expo (code_expo), PRIMARY KEY(code_reservationE)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservationevent (code_reservation INT AUTO_INCREMENT NOT NULL, code_client INT DEFAULT NULL, code_event INT DEFAULT NULL, nb_place INT NOT NULL, INDEX fk_client (code_client), INDEX fk_event (code_event), PRIMARY KEY(code_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (ID INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, datenaissance DATE NOT NULL, ville VARCHAR(30) NOT NULL, numero INT NOT NULL, image VARCHAR(80) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143CB8C5497 FOREIGN KEY (Categorie) REFERENCES categorie (ID_Cat)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B76B3CA4B FOREIGN KEY (id_user) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B78522D5A6 FOREIGN KEY (OeuvreId) REFERENCES oeuvre (ID_Oeuvre)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B354D41 FOREIGN KEY (id_blog) REFERENCES blog (idBlog)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13A4A071D3 FOREIGN KEY (code_artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE exposition ADD CONSTRAINT FK_BC31FD13792D51CF FOREIGN KEY (code_espace) REFERENCES endroit (id_endroit)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6B3CA4B FOREIGN KEY (id_user) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE949F00F5 FOREIGN KEY (code_exposition) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE408B24D0 FOREIGN KEY (ID_Artiste) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3803A2E5 FOREIGN KEY (IDUser) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT FK_EB6BE05EBE4CF56E FOREIGN KEY (OeuvreID) REFERENCES oeuvre (ID_Oeuvre)');
        $this->addSql('ALTER TABLE pending_orders ADD CONSTRAINT FK_EB6BE05E3803A2E5 FOREIGN KEY (IDUser) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservation_expo ADD CONSTRAINT FK_93552992B3878E3B FOREIGN KEY (code_expo) REFERENCES exposition (code_expo)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4B8C25CF7 FOREIGN KEY (code_client) REFERENCES user (ID)');
        $this->addSql('ALTER TABLE reservationevent ADD CONSTRAINT FK_70B2B7D4D7FB13EB FOREIGN KEY (code_event) REFERENCES event (code_event)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4B354D41');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143CB8C5497');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7792D51CF');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13792D51CF');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D4D7FB13EB');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE949F00F5');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B3878E3B');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B78522D5A6');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05EBE4CF56E');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B76B3CA4B');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC693C5CE9');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A4A071D3');
        $this->addSql('ALTER TABLE exposition DROP FOREIGN KEY FK_BC31FD13A4A071D3');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA6B3CA4B');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE408B24D0');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3803A2E5');
        $this->addSql('ALTER TABLE pending_orders DROP FOREIGN KEY FK_EB6BE05E3803A2E5');
        $this->addSql('ALTER TABLE reservation_expo DROP FOREIGN KEY FK_93552992B8C25CF7');
        $this->addSql('ALTER TABLE reservationevent DROP FOREIGN KEY FK_70B2B7D4B8C25CF7');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE endroit');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE exposition');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE pending_orders');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_expo');
        $this->addSql('DROP TABLE reservationevent');
        $this->addSql('DROP TABLE user');
    }
}
