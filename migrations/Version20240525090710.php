<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525090710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collectionn (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_B023BF37A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, collection_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, tags VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E514956FD (collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collectionn ADD CONSTRAINT FK_B023BF37A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E514956FD FOREIGN KEY (collection_id) REFERENCES collectionn (id)');
        $this->addSql('ALTER TABLE user DROP isBlocked');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collectionn DROP FOREIGN KEY FK_B023BF37A76ED395');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E514956FD');
        $this->addSql('DROP TABLE collectionn');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE `user` ADD isBlocked INT NOT NULL');
    }
}
