<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250412223933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, station_code VARCHAR(5) NOT NULL, name VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, num_dock_available INT DEFAULT NULL, num_bikes_available INT DEFAULT NULL, nb_mechanical_bike INT DEFAULT NULL, nb_ebikes INT DEFAULT NULL, due_date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_station (user_id INT NOT NULL, station_id INT NOT NULL, INDEX IDX_C734E6BBA76ED395 (user_id), INDEX IDX_C734E6BB21BDB235 (station_id), PRIMARY KEY(user_id, station_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_station ADD CONSTRAINT FK_C734E6BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_station ADD CONSTRAINT FK_C734E6BB21BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_station DROP FOREIGN KEY FK_C734E6BBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_station DROP FOREIGN KEY FK_C734E6BB21BDB235
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE station
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_station
        SQL);
    }
}
