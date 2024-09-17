<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917200331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, carname VARCHAR(255) NOT NULL, kilometrage INT NOT NULL, engine VARCHAR(255) NOT NULL, gearbox VARCHAR(255) NOT NULL, fuel VARCHAR(255) NOT NULL, provenance VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, registration_date DATE NOT NULL, technical_control VARCHAR(255) NOT NULL, first_hand TINYINT(1) NOT NULL, color VARCHAR(255) NOT NULL, doors VARCHAR(255) NOT NULL, seats INT NOT NULL, fiscal_power INT NOT NULL, horse_power INT NOT NULL, brand VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, fuel_consumption DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, inspection_form_id INT NOT NULL, timeslot_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E00CEDDED17F50A6 (uuid), INDEX IDX_E00CEDDEF7A3886F (inspection_form_id), INDEX IDX_E00CEDDEF920B9E9 (timeslot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, data LONGBLOB DEFAULT NULL, INDEX IDX_C53D045F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspection_form (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, car_model VARCHAR(255) NOT NULL, car_brand VARCHAR(255) NOT NULL, license_plate VARCHAR(255) NOT NULL, fuel_type VARCHAR(255) NOT NULL, control_type VARCHAR(255) NOT NULL, car_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_annonce (option_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_EEA18490A7C41D6F (option_id), INDEX IDX_EEA184908805AB2F (annonce_id), PRIMARY KEY(option_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timeslot (id INT AUTO_INCREMENT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF7A3886F FOREIGN KEY (inspection_form_id) REFERENCES inspection_form (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF920B9E9 FOREIGN KEY (timeslot_id) REFERENCES timeslot (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE option_annonce ADD CONSTRAINT FK_EEA18490A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_annonce ADD CONSTRAINT FK_EEA184908805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF7A3886F');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF920B9E9');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8805AB2F');
        $this->addSql('ALTER TABLE option_annonce DROP FOREIGN KEY FK_EEA18490A7C41D6F');
        $this->addSql('ALTER TABLE option_annonce DROP FOREIGN KEY FK_EEA184908805AB2F');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE inspection_form');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_annonce');
        $this->addSql('DROP TABLE timeslot');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
