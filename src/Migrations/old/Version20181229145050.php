<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181229145050 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_service ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nnc_service ADD CONSTRAINT FK_331221B6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES nnc_service (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_331221B6ED5CA9E6 ON nnc_service (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_service DROP FOREIGN KEY FK_331221B6ED5CA9E6');
        $this->addSql('DROP INDEX IDX_331221B6ED5CA9E6 ON nnc_service');
        $this->addSql('ALTER TABLE nnc_service DROP service_id');
    }
}
