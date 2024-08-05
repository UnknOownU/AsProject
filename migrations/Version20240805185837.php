<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240805185837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table annonce';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE annonce (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                car_name VARCHAR(255) NOT NULL,
                kilometrage INT NOT NULL,
                engine VARCHAR(255) NOT NULL,
                gearbox VARCHAR(255) NOT NULL,
                fuel VARCHAR(255) NOT NULL,
                provenance VARCHAR(255) NOT NULL,
                year INT NOT NULL,
                registration_date DATE NOT NULL,
                technical_control VARCHAR(255) NOT NULL,
                first_hand TINYINT(1) NOT NULL,
                color VARCHAR(255) NOT NULL,
                doors INT NOT NULL,
                seats INT NOT NULL,
                length DECIMAL(10, 2) NOT NULL,
                trunk_volume VARCHAR(255) NOT NULL,
                fiscal_power INT NOT NULL,
                horse_power INT NOT NULL,
                fuel_consumption DECIMAL(10, 2) NOT NULL,
                co2_emission INT NOT NULL,
                euro_norm VARCHAR(255) NOT NULL,
                crit_air VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonce');
    }
}
