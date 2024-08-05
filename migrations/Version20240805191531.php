<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805191531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD carname VARCHAR(255) NOT NULL, DROP car_name, DROP length, DROP trunk_volume, DROP fuel_consumption, DROP co2_emission, DROP euro_norm, DROP crit_air, DROP created_at, CHANGE description description LONGTEXT NOT NULL, CHANGE year year VARCHAR(255) NOT NULL, CHANGE doors doors VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE annonce ADD length NUMERIC(10, 2) NOT NULL, ADD trunk_volume VARCHAR(255) NOT NULL, ADD fuel_consumption NUMERIC(10, 2) NOT NULL, ADD co2_emission INT NOT NULL, ADD euro_norm VARCHAR(255) NOT NULL, ADD crit_air VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE description description TEXT NOT NULL, CHANGE year year INT NOT NULL, CHANGE doors doors INT NOT NULL, CHANGE carname car_name VARCHAR(255) NOT NULL');
    }
}
