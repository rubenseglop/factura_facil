<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309095711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, client_id INT DEFAULT NULL, number_bill INT NOT NULL, date_bill DATE NOT NULL, description_bill VARCHAR(255) NOT NULL, amount_iva DOUBLE PRECISION NOT NULL, amount_without_iva DOUBLE PRECISION NOT NULL, total_invoice_amount DOUBLE PRECISION NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_7A2119E3979B1AD6 (company_id), INDEX IDX_7A2119E319EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill_line (id INT AUTO_INCREMENT NOT NULL, bill_id INT NOT NULL, product_id INT DEFAULT NULL, description VARCHAR(600) NOT NULL, quantity INT NOT NULL, price NUMERIC(5, 2) NOT NULL, bill_line_iva INT NOT NULL, sub_total NUMERIC(5, 2) NOT NULL, INDEX IDX_220BDC5C1A8C12F5 (bill_id), INDEX IDX_220BDC5C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, client_id INT DEFAULT NULL, budget_number INT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, description VARCHAR(600) NOT NULL, amount_iva DOUBLE PRECISION NOT NULL, amount_without_iva DOUBLE PRECISION NOT NULL, total_amount DOUBLE PRECISION NOT NULL, status TINYINT(1) NOT NULL, contract_clause VARCHAR(1000) NOT NULL, visits INT DEFAULT NULL, budget_key VARCHAR(255) NOT NULL, accepted TINYINT(1) NOT NULL, INDEX IDX_73F2F77B979B1AD6 (company_id), INDEX IDX_73F2F77B19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, fiscal_adress VARCHAR(255) NOT NULL, nif VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, web VARCHAR(255) NOT NULL, boss_name VARCHAR(255) NOT NULL, boss_phone VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_C7440455979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, fiscal_address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nif VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, invoice_number INT NOT NULL, INDEX IDX_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra_user_data (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dni VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_255E63BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, product_iva INT NOT NULL, price NUMERIC(5, 2) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_D34A04AD979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_networks (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_57882007979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company_limit INT NOT NULL, name VARCHAR(255) NOT NULL, avatar VARCHAR(500) NOT NULL, status_user TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE bill_line ADD CONSTRAINT FK_220BDC5C1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE bill_line ADD CONSTRAINT FK_220BDC5C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE extra_user_data ADD CONSTRAINT FK_255E63BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE social_networks ADD CONSTRAINT FK_57882007979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill_line DROP FOREIGN KEY FK_220BDC5C1A8C12F5');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E319EB6921');
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B19EB6921');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3979B1AD6');
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B979B1AD6');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455979B1AD6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD979B1AD6');
        $this->addSql('ALTER TABLE social_networks DROP FOREIGN KEY FK_57882007979B1AD6');
        $this->addSql('ALTER TABLE bill_line DROP FOREIGN KEY FK_220BDC5C4584665A');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE extra_user_data DROP FOREIGN KEY FK_255E63BCA76ED395');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE bill_line');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE extra_user_data');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE social_networks');
        $this->addSql('DROP TABLE user');
    }
}
