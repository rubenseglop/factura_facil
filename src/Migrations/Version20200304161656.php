<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304161656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill ADD amount_iva DOUBLE PRECISION NOT NULL, ADD amount_without_iva DOUBLE PRECISION NOT NULL, ADD total_invoice_amount DOUBLE PRECISION NOT NULL, DROP total_bill_iva, DROP total_import_bill, CHANGE client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill ADD total_bill_iva INT NOT NULL, ADD total_import_bill NUMERIC(5, 2) NOT NULL, DROP amount_iva, DROP amount_without_iva, DROP total_invoice_amount, CHANGE client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE birth_date birth_date DATE DEFAULT \'NULL\', CHANGE phone_number phone_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
