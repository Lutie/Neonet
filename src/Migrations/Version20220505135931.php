<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505135931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_bill ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nnc_bill ADD CONSTRAINT FK_148CB94919EB6921 FOREIGN KEY (client_id) REFERENCES nnc_client (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_148CB94919EB6921 ON nnc_bill (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_bill DROP FOREIGN KEY FK_148CB94919EB6921');
        $this->addSql('DROP INDEX IDX_148CB94919EB6921 ON nnc_bill');
        $this->addSql('ALTER TABLE nnc_bill DROP client_id');
    }
}
