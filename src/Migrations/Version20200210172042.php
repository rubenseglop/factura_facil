<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210172042 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, bill_line_id INT NOT NULL, number_bill INT NOT NULL, date_bill DATE NOT NULL, description_bill VARCHAR(255) NOT NULL, total_bill_iva INT NOT NULL, total_import_bill NUMERIC(5, 2) NOT NULL, INDEX IDX_7A2119E3B9B8415D (bill_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill_line (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, price NUMERIC(5, 2) NOT NULL, bill_line_iva INT NOT NULL, sub_total NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fiscal_adress VARCHAR(255) NOT NULL, nif VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, web VARCHAR(255) NOT NULL, boss_name VARCHAR(255) NOT NULL, boss_phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, social_net_works_id INT DEFAULT NULL, client_id INT NOT NULL, product_id INT NOT NULL, bills_company_id INT NOT NULL, name VARCHAR(255) NOT NULL, fiscal_address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nif VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_4FBF094FA76ED395 (user_id), INDEX IDX_4FBF094F86361C3A (social_net_works_id), INDEX IDX_4FBF094F19EB6921 (client_id), INDEX IDX_4FBF094F4584665A (product_id), INDEX IDX_4FBF094F98F4C4DA (bills_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, product_iva INT NOT NULL, price NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_networks (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3B9B8415D FOREIGN KEY (bill_line_id) REFERENCES bill_line (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F86361C3A FOREIGN KEY (social_net_works_id) REFERENCES social_networks (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F98F4C4DA FOREIGN KEY (bills_company_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE user ADD company_limit INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) NOT NULL, ADD avatar VARCHAR(255) NOT NULL, ADD status_user TINYINT(1) NOT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F98F4C4DA');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3B9B8415D');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F19EB6921');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F4584665A');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F86361C3A');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE bill_line');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE social_networks');
        $this->addSql('ALTER TABLE user DROP company_limit, DROP name, DROP phone_number, DROP avatar, DROP status_user, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
