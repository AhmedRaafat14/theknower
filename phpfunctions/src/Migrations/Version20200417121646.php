<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417121646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE contributions_count contributions_count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contribution CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contribution CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE bookmarks_count bookmarks_count INT DEFAULT NULL, CHANGE comments_count comments_count INT DEFAULT NULL, CHANGE likes_count likes_count INT DEFAULT NULL, CHANGE contributions_count contributions_count INT DEFAULT NULL');
    }
}
