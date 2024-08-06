<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240806141010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, carname VARCHAR(255) NOT NULL, kilometrage INT NOT NULL, engine VARCHAR(255) NOT NULL, gearbox VARCHAR(255) NOT NULL, fuel VARCHAR(255) NOT NULL, provenance VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, registration_date DATE NOT NULL, technical_control VARCHAR(255) NOT NULL, first_hand TINYINT(1) NOT NULL, color VARCHAR(255) NOT NULL, doors VARCHAR(255) NOT NULL, seats INT NOT NULL, fiscal_power INT NOT NULL, horse_power INT NOT NULL, image LONGBLOB DEFAULT NULL, brand VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, fuel_consumption DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonce');
    }
}
