<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250419181355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2921FB69731415A ON porte_monnaie (numero_compte)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD numero_transaction VARCHAR(255) NOT NULL, ADD frais_transaction DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD pays_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649A6E44244 ON user (pays_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_2921FB69731415A ON porte_monnaie
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP numero_transaction, DROP frais_transaction
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A6E44244
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D649A6E44244 ON `user`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP pays_id
        SQL);
    }
}
