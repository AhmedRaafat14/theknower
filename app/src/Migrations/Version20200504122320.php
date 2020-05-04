<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504122320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contribution_user (contribution_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4E41A211FE5E5FBD (contribution_id), INDEX IDX_4E41A211A76ED395 (user_id), PRIMARY KEY(contribution_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contribution_user ADD CONSTRAINT FK_4E41A211FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contribution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contribution_user ADD CONSTRAINT FK_4E41A211A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE contributions_count contributions_count INT DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contribution CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contribution_user');
        $this->addSql('ALTER TABLE contribution CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE contributions_count contributions_count INT DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
