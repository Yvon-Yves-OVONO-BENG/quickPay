<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413144402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD porte_monnaie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64974C9BB66 FOREIGN KEY (porte_monnaie_id) REFERENCES porte_monnaie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64974C9BB66 ON user (porte_monnaie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64974C9BB66');
        $this->addSql('DROP INDEX UNIQ_8D93D64974C9BB66 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP porte_monnaie_id');
    }
}
