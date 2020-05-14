<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514095108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, contribution_id_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9474526C9D86650F (user_id_id), INDEX IDX_9474526C1A3795E5 (contribution_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1A3795E5 FOREIGN KEY (contribution_id_id) REFERENCES contribution (id)');
        $this->addSql('ALTER TABLE user DROP bookmarks_count, DROP likes_count, DROP contributions_count, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contribution DROP likes_count, DROP bookmarks_count, CHANGE comments_count comments_count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE contribution ADD likes_count INT DEFAULT NULL, ADD bookmarks_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD bookmarks_count INT DEFAULT NULL, ADD likes_count INT DEFAULT NULL, ADD contributions_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
