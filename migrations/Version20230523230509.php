<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523230509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066C0990423 FOREIGN KEY (player1_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066D22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F70666A90CCA8 FOREIGN KEY (player3_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066F747F411 FOREIGN KEY (player4_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066CF6600E FOREIGN KEY (winner) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066993D3FF FOREIGN KEY (loser) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE player CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE referee CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE gender gender VARCHAR(10) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066C0990423');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066D22CABCD');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F70666A90CCA8');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066F747F411');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066CF6600E');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066993D3FF');
        $this->addSql('ALTER TABLE news CHANGE image image VARCHAR(255) DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE player CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reclamation CHANGE description description VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE referee CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE image image VARCHAR(255) DEFAULT \'NULL\', CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\', CHANGE gender gender VARCHAR(10) DEFAULT \'NULL\', CHANGE phone_number phone_number VARCHAR(15) DEFAULT \'NULL\'');
    }
}
