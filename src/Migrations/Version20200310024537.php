<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310024537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE budget_line (id INT AUTO_INCREMENT NOT NULL, budget_id INT NOT NULL, product_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, price NUMERIC(5, 2) NOT NULL, iva INT NOT NULL, sub_total NUMERIC(10, 2) NOT NULL, INDEX IDX_ABD0B6A636ABA6B8 (budget_id), INDEX IDX_ABD0B6A64584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget_line ADD CONSTRAINT FK_ABD0B6A636ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('ALTER TABLE budget_line ADD CONSTRAINT FK_ABD0B6A64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE bill CHANGE client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget CHANGE client_id client_id INT DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL, CHANGE visits visits INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE budget_line');
        $this->addSql('ALTER TABLE bill CHANGE client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_line CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget CHANGE client_id client_id INT DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT \'NULL\', CHANGE visits visits INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra_user_data CHANGE dni dni VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE birth_date birth_date DATE DEFAULT \'NULL\', CHANGE phone_number phone_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
