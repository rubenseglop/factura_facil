<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303203129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE extra_user_data (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dni VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_255E63BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE extra_user_data ADD CONSTRAINT FK_255E63BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bill ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_7A2119E319EB6921 ON bill (client_id)');
        $this->addSql('ALTER TABLE bill_line ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE bill_line ADD CONSTRAINT FK_220BDC5C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_220BDC5C4584665A ON bill_line (product_id)');
        $this->addSql('ALTER TABLE user DROP phone_number, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE extra_user_data');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E319EB6921');
        $this->addSql('DROP INDEX IDX_7A2119E319EB6921 ON bill');
        $this->addSql('ALTER TABLE bill DROP client_id');
        $this->addSql('ALTER TABLE bill_line DROP FOREIGN KEY FK_220BDC5C4584665A');
        $this->addSql('DROP INDEX IDX_220BDC5C4584665A ON bill_line');
        $this->addSql('ALTER TABLE bill_line DROP product_id');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
