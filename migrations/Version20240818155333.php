<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240818155333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE timeslot (id INT AUTO_INCREMENT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technical_control_appointment ADD timeslot_id INT NOT NULL');
        $this->addSql('ALTER TABLE technical_control_appointment ADD CONSTRAINT FK_50CAC049F920B9E9 FOREIGN KEY (timeslot_id) REFERENCES timeslot (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50CAC049F920B9E9 ON technical_control_appointment (timeslot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technical_control_appointment DROP FOREIGN KEY FK_50CAC049F920B9E9');
        $this->addSql('DROP TABLE timeslot');
        $this->addSql('DROP INDEX UNIQ_50CAC049F920B9E9 ON technical_control_appointment');
        $this->addSql('ALTER TABLE technical_control_appointment DROP timeslot_id');
    }
}
