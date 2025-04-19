<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417201721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE action_log (id INT AUTO_INCREMENT NOT NULL, action_log VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE audit_log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, action_log_id INT DEFAULT NULL, date_action_at DATETIME NOT NULL, INDEX IDX_F6E1C0F5A76ED395 (user_id), INDEX IDX_F6E1C0F528576CED (action_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie_user (id INT AUTO_INCREMENT NOT NULL, categorie_user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE code_qr (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qr_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5115D31FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cryptographie (id INT AUTO_INCREMENT NOT NULL, cryptographie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE demande_modification_mot_de_passe (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, INDEX IDX_8D7D5F9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE licence (id INT AUTO_INCREMENT NOT NULL, nombre_jours INT DEFAULT NULL, date_expiration_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT DEFAULT NULL, destinataire_id INT DEFAULT NULL, cryptographie_id INT DEFAULT NULL, supprime_par_id INT DEFAULT NULL, message_crypte LONGTEXT NOT NULL, envoye_le_at DATETIME NOT NULL, aes_iv VARCHAR(255) DEFAULT NULL, supprime TINYINT(1) NOT NULL, supprimer_definitivement TINYINT(1) NOT NULL, supprime_le_at DATETIME DEFAULT NULL, spam TINYINT(1) DEFAULT NULL, lu TINYINT(1) NOT NULL, important TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_B6BD307F10335F61 (expediteur_id), INDEX IDX_B6BD307FA4F84F6E (destinataire_id), INDEX IDX_B6BD307FB07FF6A5 (cryptographie_id), INDEX IDX_B6BD307FACC02199 (supprime_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE porte_monnaie (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, solde NUMERIC(12, 2) DEFAULT NULL, UNIQUE INDEX UNIQ_2921FB6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question_secrete (id INT AUTO_INCREMENT NOT NULL, question_secrete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reponse_question (id INT AUTO_INCREMENT NOT NULL, question_secrete_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, INDEX IDX_E97BC6396BD4A821 (question_secrete_id), INDEX IDX_E97BC639A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statut_transaction (id INT AUTO_INCREMENT NOT NULL, statut_transaction VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT DEFAULT NULL, destinataire_id INT DEFAULT NULL, statut_transaction_id INT DEFAULT NULL, montant NUMERIC(12, 2) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_723705D110335F61 (expediteur_id), INDEX IDX_723705D1A4F84F6E (destinataire_id), INDEX IDX_723705D152719CE0 (statut_transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE type_user (id INT AUTO_INCREMENT NOT NULL, type_user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, porte_monnaie_id INT DEFAULT NULL, code_qr_id INT DEFAULT NULL, type_user_id INT DEFAULT NULL, categorie_user_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, cle_rsa_publique VARCHAR(255) DEFAULT NULL, cle_rsa_privee VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, num_cni VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6494296D31F (genre_id), UNIQUE INDEX UNIQ_8D93D64974C9BB66 (porte_monnaie_id), UNIQUE INDEX UNIQ_8D93D649B6F3531B (code_qr_id), INDEX IDX_8D93D6498F4FBC60 (type_user_id), INDEX IDX_8D93D649F8ED7D37 (categorie_user_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_log ADD CONSTRAINT FK_F6E1C0F5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_log ADD CONSTRAINT FK_F6E1C0F528576CED FOREIGN KEY (action_log_id) REFERENCES action_log (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE code_qr ADD CONSTRAINT FK_5115D31FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande_modification_mot_de_passe ADD CONSTRAINT FK_8D7D5F9EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307F10335F61 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB07FF6A5 FOREIGN KEY (cryptographie_id) REFERENCES cryptographie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FACC02199 FOREIGN KEY (supprime_par_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE porte_monnaie ADD CONSTRAINT FK_2921FB6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC6396BD4A821 FOREIGN KEY (question_secrete_id) REFERENCES question_secrete (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D152719CE0 FOREIGN KEY (statut_transaction_id) REFERENCES statut_transaction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6494296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64974C9BB66 FOREIGN KEY (porte_monnaie_id) REFERENCES porte_monnaie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649B6F3531B FOREIGN KEY (code_qr_id) REFERENCES code_qr (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6498F4FBC60 FOREIGN KEY (type_user_id) REFERENCES type_user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F8ED7D37 FOREIGN KEY (categorie_user_id) REFERENCES categorie_user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_log DROP FOREIGN KEY FK_F6E1C0F5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE audit_log DROP FOREIGN KEY FK_F6E1C0F528576CED
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE code_qr DROP FOREIGN KEY FK_5115D31FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demande_modification_mot_de_passe DROP FOREIGN KEY FK_8D7D5F9EA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F10335F61
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA4F84F6E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB07FF6A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FACC02199
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE porte_monnaie DROP FOREIGN KEY FK_2921FB6A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC6396BD4A821
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC639A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D110335F61
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A4F84F6E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D152719CE0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494296D31F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64974C9BB66
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B6F3531B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6498F4FBC60
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F8ED7D37
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE action_log
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE audit_log
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE code_qr
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cryptographie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE demande_modification_mot_de_passe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE licence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE porte_monnaie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question_secrete
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reponse_question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE statut_transaction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transaction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE type_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
