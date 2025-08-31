<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117225801 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_bill CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE nnc_staging CHANGE contact_name contact_name VARCHAR(255) DEFAULT NULL, CHANGE contact_phone contact_phone VARCHAR(255) DEFAULT NULL, CHANGE contact_address contact_address VARCHAR(255) DEFAULT NULL, CHANGE contact_zipcode contact_zipcode VARCHAR(255) DEFAULT NULL, CHANGE contact_city contact_city VARCHAR(255) DEFAULT NULL, CHANGE delivery_date delivery_date DATETIME DEFAULT NULL, CHANGE streamer streamer TINYINT(1) DEFAULT NULL, CHANGE vod vod TINYINT(1) DEFAULT NULL, CHANGE tv_channel_plan tv_channel_plan VARCHAR(255) DEFAULT NULL, CHANGE radio_channel_plan radio_channel_plan VARCHAR(255) DEFAULT NULL, CHANGE room_list room_list VARCHAR(255) DEFAULT NULL, CHANGE tv_brand tv_brand LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE gui_type gui_type VARCHAR(255) DEFAULT NULL, CHANGE ssid_list ssid_list LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE head_brand head_brand VARCHAR(255) DEFAULT NULL, CHANGE controller_brand controller_brand VARCHAR(255) DEFAULT NULL, CHANGE ssid_wifi ssid_wifi VARCHAR(255) DEFAULT NULL, CHANGE vlan_wifi vlan_wifi VARCHAR(255) DEFAULT NULL, CHANGE guest_ip guest_ip VARCHAR(255) DEFAULT NULL, CHANGE ssid_vlan ssid_vlan VARCHAR(255) DEFAULT NULL, CHANGE lan_file_name lan_file_name VARCHAR(255) DEFAULT NULL, CHANGE switch_quantity switch_quantity INT DEFAULT NULL, CHANGE trader trader VARCHAR(255) DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE nnc_user CHANGE date date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_bill CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE nnc_staging CHANGE contact_name contact_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact_phone contact_phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact_address contact_address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact_zipcode contact_zipcode VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact_city contact_city VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE delivery_date delivery_date DATETIME NOT NULL, CHANGE streamer streamer TINYINT(1) NOT NULL, CHANGE vod vod TINYINT(1) NOT NULL, CHANGE tv_channel_plan tv_channel_plan VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE radio_channel_plan radio_channel_plan VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE room_list room_list VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE tv_brand tv_brand LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE gui_type gui_type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ssid_list ssid_list LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE head_brand head_brand VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE controller_brand controller_brand VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ssid_wifi ssid_wifi VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE vlan_wifi vlan_wifi VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE guest_ip guest_ip VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ssid_vlan ssid_vlan VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lan_file_name lan_file_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE switch_quantity switch_quantity INT NOT NULL, CHANGE trader trader VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE nnc_user CHANGE date date DATETIME NOT NULL');
    }
}
