<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117190639 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nnc_staging (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nas_id VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_phone VARCHAR(255) NOT NULL, contact_address VARCHAR(255) NOT NULL, contact_zipcode VARCHAR(255) NOT NULL, contact_city VARCHAR(255) NOT NULL, delivery_date DATETIME NOT NULL, hoist_standard TINYINT(1) NOT NULL, staging_type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', streamer TINYINT(1) NOT NULL, vod TINYINT(1) NOT NULL, tv_channel_plan VARCHAR(255) NOT NULL, radio_channel_plan VARCHAR(255) NOT NULL, room_list VARCHAR(255) NOT NULL, staging_brand LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', gui_type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ssid_list LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', head_brand VARCHAR(255) NOT NULL, controller_brand LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', tv_on_wifi TINYINT(1) NOT NULL, ssid_wifi VARCHAR(255) NOT NULL, vlan_wifi VARCHAR(255) NOT NULL, guest_ip VARCHAR(255) NOT NULL, ssid_vlan VARCHAR(255) NOT NULL, lan_filename VARCHAR(255) NOT NULL, switch_quantity INT NOT NULL, trader LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date DATETIME NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6FDD3241A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nnc_staging ADD CONSTRAINT FK_6FDD3241A76ED395 FOREIGN KEY (user_id) REFERENCES nnc_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE nnc_staging');
    }
}
