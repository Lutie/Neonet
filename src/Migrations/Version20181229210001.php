<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181229210001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bill_service');
        $this->addSql('ALTER TABLE nnc_bill ADD services LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD item LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bill_service (bill_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_155EAECD1A8C12F5 (bill_id), INDEX IDX_155EAECDED5CA9E6 (service_id), PRIMARY KEY(bill_id, service_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bill_service ADD CONSTRAINT FK_155EAECD1A8C12F5 FOREIGN KEY (bill_id) REFERENCES nnc_bill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill_service ADD CONSTRAINT FK_155EAECDED5CA9E6 FOREIGN KEY (service_id) REFERENCES nnc_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nnc_bill DROP services, DROP item');
    }
}
