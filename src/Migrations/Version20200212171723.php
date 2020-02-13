<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212171723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajaction ADD user_id INT DEFAULT NULL, ADD copmte_id INT DEFAULT NULL, ADD prenom_e VARCHAR(255) DEFAULT NULL, ADD nom_e VARCHAR(255) DEFAULT NULL, ADD preno_r VARCHAR(255) DEFAULT NULL, ADD nom_r VARCHAR(255) DEFAULT NULL, ADD type_piece_envoi VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE trajaction ADD CONSTRAINT FK_7F43878A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trajaction ADD CONSTRAINT FK_7F438784B848A6B FOREIGN KEY (copmte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_7F43878A76ED395 ON trajaction (user_id)');
        $this->addSql('CREATE INDEX IDX_7F438784B848A6B ON trajaction (copmte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajaction DROP FOREIGN KEY FK_7F43878A76ED395');
        $this->addSql('ALTER TABLE trajaction DROP FOREIGN KEY FK_7F438784B848A6B');
        $this->addSql('DROP INDEX IDX_7F43878A76ED395 ON trajaction');
        $this->addSql('DROP INDEX IDX_7F438784B848A6B ON trajaction');
        $this->addSql('ALTER TABLE trajaction DROP user_id, DROP copmte_id, DROP prenom_e, DROP nom_e, DROP preno_r, DROP nom_r, DROP type_piece_envoi');
    }
}
