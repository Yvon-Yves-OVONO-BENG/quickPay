<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413230858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912E4AD80');
        $this->addSql('CREATE TABLE code_qr (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qr_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5115D31FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE code_qr ADD CONSTRAINT FK_5115D31FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE qr_code DROP FOREIGN KEY FK_7D8B1FB5A76ED395');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP INDEX UNIQ_8D93D64912E4AD80 ON user');
        $this->addSql('ALTER TABLE user CHANGE qr_code_id code_qr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B6F3531B FOREIGN KEY (code_qr_id) REFERENCES code_qr (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B6F3531B ON user (code_qr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B6F3531B');
        $this->addSql('CREATE TABLE qr_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qr_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_7D8B1FB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE qr_code ADD CONSTRAINT FK_7D8B1FB5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE code_qr DROP FOREIGN KEY FK_5115D31FA76ED395');
        $this->addSql('DROP TABLE code_qr');
        $this->addSql('DROP INDEX UNIQ_8D93D649B6F3531B ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE code_qr_id qr_code_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64912E4AD80 FOREIGN KEY (qr_code_id) REFERENCES qr_code (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64912E4AD80 ON `user` (qr_code_id)');
    }
}
