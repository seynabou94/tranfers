<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212162331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trajaction (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, montat INT DEFAULT NULL, frais INT DEFAULT NULL, client_emetteur VARCHAR(255) DEFAULT NULL, type_piece_emetteur VARCHAR(255) DEFAULT NULL, numero_piece_emetteur INT DEFAULT NULL, date_envoi DATETIME DEFAULT NULL, telephone_emetteur INT DEFAULT NULL, commission_emetteur DOUBLE PRECISION DEFAULT NULL, date_retait DATETIME DEFAULT NULL, client_recepteur VARCHAR(255) DEFAULT NULL, type_piece_recepteur VARCHAR(255) DEFAULT NULL, telepho_recepteur INT DEFAULT NULL, numero_piece_recepteur INT NOT NULL, commission_recepteur DOUBLE PRECISION DEFAULT NULL, commission_systeme DOUBLE PRECISION DEFAULT NULL, taxi_etat DOUBLE PRECISION DEFAULT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, frais INT NOT NULL, borne_sup INT DEFAULT NULL, borne_inf INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxi (id INT AUTO_INCREMENT NOT NULL, taxi_etat INT DEFAULT NULL, taxi_systeme INT DEFAULT NULL, emeteur VARCHAR(255) DEFAULT NULL, recepteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trajaction');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE taxi');
    }
}
