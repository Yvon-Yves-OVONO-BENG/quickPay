<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908221600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_paiement (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, recu_par_id INT DEFAULT NULL, montant_avance INT DEFAULT NULL, date_avance_at DATE DEFAULT NULL, INDEX IDX_710402EC7F2DEE08 (facture_id), INDEX IDX_710402EC59820928 (recu_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescripteur (id INT AUTO_INCREMENT NOT NULL, prescripteur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_secrete (id INT AUTO_INCREMENT NOT NULL, question_secrete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_question (id INT AUTO_INCREMENT NOT NULL, question_secrete_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, INDEX IDX_E97BC6396BD4A821 (question_secrete_id), INDEX IDX_E97BC639A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_paiement ADD CONSTRAINT FK_710402EC7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE historique_paiement ADD CONSTRAINT FK_710402EC59820928 FOREIGN KEY (recu_par_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC6396BD4A821 FOREIGN KEY (question_secrete_id) REFERENCES question_secrete (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE facture ADD prescripteur_id INT DEFAULT NULL, ADD avance INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410D486E642 FOREIGN KEY (prescripteur_id) REFERENCES prescripteur (id)');
        $this->addSql('CREATE INDEX IDX_FE866410D486E642 ON facture (prescripteur_id)');
        $this->addSql('ALTER TABLE patient ADD termine TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD retire TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE profil ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B2974296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_E6D6B2974296D31F ON profil (genre_id)');
        $this->addSql('ALTER TABLE user ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494296D31F ON user (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B2974296D31F');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494296D31F');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410D486E642');
        $this->addSql('ALTER TABLE historique_paiement DROP FOREIGN KEY FK_710402EC7F2DEE08');
        $this->addSql('ALTER TABLE historique_paiement DROP FOREIGN KEY FK_710402EC59820928');
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC6396BD4A821');
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC639A76ED395');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE historique_paiement');
        $this->addSql('DROP TABLE prescripteur');
        $this->addSql('DROP TABLE question_secrete');
        $this->addSql('DROP TABLE reponse_question');
        $this->addSql('DROP INDEX IDX_FE866410D486E642 ON facture');
        $this->addSql('ALTER TABLE facture DROP prescripteur_id, DROP avance');
        $this->addSql('ALTER TABLE patient DROP termine');
        $this->addSql('ALTER TABLE produit DROP retire');
        $this->addSql('DROP INDEX IDX_E6D6B2974296D31F ON profil');
        $this->addSql('ALTER TABLE profil DROP genre_id');
        $this->addSql('DROP INDEX IDX_8D93D6494296D31F ON `user`');
        $this->addSql('ALTER TABLE `user` DROP genre_id');
    }
}
