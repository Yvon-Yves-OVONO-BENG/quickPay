<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416210753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_user (id INT AUTO_INCREMENT NOT NULL, categorie_user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD categorie_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F8ED7D37 FOREIGN KEY (categorie_user_id) REFERENCES categorie_user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F8ED7D37 ON user (categorie_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F8ED7D37');
        $this->addSql('DROP TABLE categorie_user');
        $this->addSql('DROP INDEX IDX_8D93D649F8ED7D37 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP categorie_user_id');
    }
}
