<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413134231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE porte_monnaie (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, solde NUMERIC(12, 2) DEFAULT NULL, UNIQUE INDEX UNIQ_2921FB6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qr_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qr_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D8B1FB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_transaction (id INT AUTO_INCREMENT NOT NULL, statut_transaction VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT DEFAULT NULL, destinataire_id INT DEFAULT NULL, statut_transaction_id INT DEFAULT NULL, montant NUMERIC(12, 2) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_723705D110335F61 (expediteur_id), INDEX IDX_723705D1A4F84F6E (destinataire_id), INDEX IDX_723705D152719CE0 (statut_transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE porte_monnaie ADD CONSTRAINT FK_2921FB6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE qr_code ADD CONSTRAINT FK_7D8B1FB5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D152719CE0 FOREIGN KEY (statut_transaction_id) REFERENCES statut_transaction (id)');
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B2974296D31F');
        $this->addSql('DROP TABLE profil');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, user_id INT DEFAULT NULL, modifie_at DATETIME DEFAULT NULL, image_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contact VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E6D6B2974296D31F (genre_id), UNIQUE INDEX UNIQ_E6D6B297A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B2974296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE porte_monnaie DROP FOREIGN KEY FK_2921FB6A76ED395');
        $this->addSql('ALTER TABLE qr_code DROP FOREIGN KEY FK_7D8B1FB5A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D110335F61');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A4F84F6E');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D152719CE0');
        $this->addSql('DROP TABLE porte_monnaie');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP TABLE statut_transaction');
        $this->addSql('DROP TABLE transaction');
    }
}
