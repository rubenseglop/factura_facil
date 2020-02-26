<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219182735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_C7440455979B1AD6 ON client (company_id)');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F19EB6921');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F4584665A');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F86361C3A');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F98F4C4DA');
        $this->addSql('DROP INDEX IDX_4FBF094F4584665A ON company');
        $this->addSql('DROP INDEX IDX_4FBF094F86361C3A ON company');
        $this->addSql('DROP INDEX IDX_4FBF094F98F4C4DA ON company');
        $this->addSql('DROP INDEX IDX_4FBF094F19EB6921 ON company');
        $this->addSql('ALTER TABLE company DROP social_net_works_id, DROP client_id, DROP product_id, DROP bills_company_id');
        $this->addSql('ALTER TABLE product ADD company_id INT NOT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD979B1AD6 ON product (company_id)');
        $this->addSql('ALTER TABLE social_networks ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE social_networks ADD CONSTRAINT FK_57882007979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_57882007979B1AD6 ON social_networks (company_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455979B1AD6');
        $this->addSql('DROP INDEX IDX_C7440455979B1AD6 ON client');
        $this->addSql('ALTER TABLE company ADD social_net_works_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL, ADD bills_company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F86361C3A FOREIGN KEY (social_net_works_id) REFERENCES social_networks (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F98F4C4DA FOREIGN KEY (bills_company_id) REFERENCES bill (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F4584665A ON company (product_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F86361C3A ON company (social_net_works_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F98F4C4DA ON company (bills_company_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F19EB6921 ON company (client_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD979B1AD6');
        $this->addSql('DROP INDEX IDX_D34A04AD979B1AD6 ON product');
        $this->addSql('ALTER TABLE product DROP company_id, DROP status');
        $this->addSql('ALTER TABLE social_networks DROP FOREIGN KEY FK_57882007979B1AD6');
        $this->addSql('DROP INDEX IDX_57882007979B1AD6 ON social_networks');
        $this->addSql('ALTER TABLE social_networks DROP company_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
