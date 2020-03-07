<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:src/Migrations/Version20200307174353.php
final class Version20200307174353 extends AbstractMigration
=======
final class Version20200306234031 extends AbstractMigration
>>>>>>> 1590fe7dcac87d5983278b0d188f7a0bb5b67e32:src/Migrations/Version20200306234031.php
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill CHANGE client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill CHANGE client_id client_id INT NOT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE birth_date birth_date DATE DEFAULT \'NULL\', CHANGE phone_number phone_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
