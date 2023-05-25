<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525093935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matcch (id INT AUTO_INCREMENT NOT NULL, player1_id INT NOT NULL, player2_id INT NOT NULL, player3_id INT DEFAULT NULL, player4_id INT DEFAULT NULL, winner INT DEFAULT NULL, type VARCHAR(10) NOT NULL, date DATE NOT NULL, tournament VARCHAR(255) NOT NULL, resultat VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_28F7066C0990423 (player1_id), INDEX IDX_28F7066D22CABCD (player2_id), INDEX IDX_28F70666A90CCA8 (player3_id), INDEX IDX_28F7066F747F411 (player4_id), INDEX IDX_28F7066CF6600E (winner), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_winner (match_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_AD99990F2ABEACD6 (match_id), INDEX IDX_AD99990F99E6F5DF (player_id), PRIMARY KEY(match_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_referee (match_id INT NOT NULL, referee_id INT NOT NULL, INDEX IDX_A1A9EC2D2ABEACD6 (match_id), INDEX IDX_A1A9EC2D4A087CA2 (referee_id), PRIMARY KEY(match_id, referee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, gender VARCHAR(255) NOT NULL, height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, handedness VARCHAR(255) NOT NULL, ranking INT NOT NULL, titles INT NOT NULL, bio VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_98197A65A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sujet VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referee (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066C0990423 FOREIGN KEY (player1_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066D22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F70666A90CCA8 FOREIGN KEY (player3_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066F747F411 FOREIGN KEY (player4_id) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE matcch ADD CONSTRAINT FK_28F7066CF6600E FOREIGN KEY (winner) REFERENCES player (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE match_winner ADD CONSTRAINT FK_AD99990F2ABEACD6 FOREIGN KEY (match_id) REFERENCES matcch (id)');
        $this->addSql('ALTER TABLE match_winner ADD CONSTRAINT FK_AD99990F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE match_referee ADD CONSTRAINT FK_A1A9EC2D2ABEACD6 FOREIGN KEY (match_id) REFERENCES matcch (id)');
        $this->addSql('ALTER TABLE match_referee ADD CONSTRAINT FK_A1A9EC2D4A087CA2 FOREIGN KEY (referee_id) REFERENCES referee (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066C0990423');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066D22CABCD');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F70666A90CCA8');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066F747F411');
        $this->addSql('ALTER TABLE matcch DROP FOREIGN KEY FK_28F7066CF6600E');
        $this->addSql('ALTER TABLE match_winner DROP FOREIGN KEY FK_AD99990F2ABEACD6');
        $this->addSql('ALTER TABLE match_winner DROP FOREIGN KEY FK_AD99990F99E6F5DF');
        $this->addSql('ALTER TABLE match_referee DROP FOREIGN KEY FK_A1A9EC2D2ABEACD6');
        $this->addSql('ALTER TABLE match_referee DROP FOREIGN KEY FK_A1A9EC2D4A087CA2');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP TABLE matcch');
        $this->addSql('DROP TABLE match_winner');
        $this->addSql('DROP TABLE match_referee');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE referee');
        $this->addSql('DROP TABLE user');
    }
}
