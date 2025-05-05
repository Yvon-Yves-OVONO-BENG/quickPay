<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250504182906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, arrondissement_id INT DEFAULT NULL, chef_agence_id INT DEFAULT NULL, agence VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, INDEX IDX_64C19AA9407DBC11 (arrondissement_id), INDEX IDX_64C19AA94546703 (chef_agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, arrondissement VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, INDEX IDX_3A3B64C4CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, departement VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, poste VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, region VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, INDEX IDX_F62F176A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA94546703 FOREIGN KEY (chef_agence_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE user ADD agence_id INT DEFAULT NULL, ADD poste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D725330D ON user (agence_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A0905086 ON user (poste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D725330D');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A0905086');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9407DBC11');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA94546703');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4CCF9E01E');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176A6E44244');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP INDEX IDX_8D93D649D725330D ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649A0905086 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP agence_id, DROP poste_id');
    }
}
