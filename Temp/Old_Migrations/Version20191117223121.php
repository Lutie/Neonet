<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117223121 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_staging CHANGE gui_type gui_type VARCHAR(255) NOT NULL, CHANGE controller_brand controller_brand VARCHAR(255) NOT NULL, CHANGE trader trader VARCHAR(255) NOT NULL, CHANGE staging_brand tv_brand LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE lan_filename lan_file_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_staging CHANGE gui_type gui_type LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE controller_brand controller_brand LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE trader trader LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE tv_brand staging_brand LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE lan_file_name lan_filename VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
