<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250830223647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nnc_bill (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, price INT NOT NULL, services LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', items LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) NOT NULL, date DATETIME DEFAULT NULL, name VARCHAR(100) NOT NULL, modification_date DATETIME NOT NULL, INDEX IDX_148CB949A76ED395 (user_id), INDEX IDX_148CB94919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nnc_client (id INT AUTO_INCREMENT NOT NULL, street LONGTEXT DEFAULT NULL, city LONGTEXT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nnc_item (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, INDEX IDX_71B685B4ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nnc_service (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, dependency INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, INDEX IDX_331221B6ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nnc_staging (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nas_id VARCHAR(255) NOT NULL, license_nas_id TINYINT(1) NOT NULL, contact_name VARCHAR(255) DEFAULT NULL, contact_phone VARCHAR(255) DEFAULT NULL, contact_address VARCHAR(255) DEFAULT NULL, contact_zipcode VARCHAR(255) DEFAULT NULL, contact_city VARCHAR(255) DEFAULT NULL, delivery_date DATETIME DEFAULT NULL, hoist_standard TINYINT(1) NOT NULL, standard_file_path VARCHAR(255) DEFAULT NULL, staging_type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', streamer TINYINT(1) DEFAULT NULL, vod TINYINT(1) DEFAULT NULL, tv_channel_plan VARCHAR(255) DEFAULT NULL, radio_channel_plan VARCHAR(255) DEFAULT NULL, room_list VARCHAR(255) DEFAULT NULL, tv_brand LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', gui_type VARCHAR(255) DEFAULT NULL, ssid_list LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', head_brand VARCHAR(255) DEFAULT NULL, controller_brand VARCHAR(255) DEFAULT NULL, tv_on_wifi TINYINT(1) NOT NULL, ssid_wifi VARCHAR(255) DEFAULT NULL, vlan_wifi VARCHAR(255) DEFAULT NULL, guest_ip VARCHAR(255) DEFAULT NULL, ssid_vlan VARCHAR(255) DEFAULT NULL, lan_file_path VARCHAR(255) DEFAULT NULL, lan_file_name VARCHAR(255) DEFAULT NULL, switch_quantity INT DEFAULT NULL, trader VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, modification_date DATETIME NOT NULL, INDEX IDX_6FDD3241A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nnc_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_E33E76E3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nnc_bill ADD CONSTRAINT FK_148CB949A76ED395 FOREIGN KEY (user_id) REFERENCES nnc_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nnc_bill ADD CONSTRAINT FK_148CB94919EB6921 FOREIGN KEY (client_id) REFERENCES nnc_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nnc_item ADD CONSTRAINT FK_71B685B4ED5CA9E6 FOREIGN KEY (service_id) REFERENCES nnc_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nnc_service ADD CONSTRAINT FK_331221B6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES nnc_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nnc_staging ADD CONSTRAINT FK_6FDD3241A76ED395 FOREIGN KEY (user_id) REFERENCES nnc_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nnc_bill DROP FOREIGN KEY FK_148CB94919EB6921');
        $this->addSql('ALTER TABLE nnc_item DROP FOREIGN KEY FK_71B685B4ED5CA9E6');
        $this->addSql('ALTER TABLE nnc_service DROP FOREIGN KEY FK_331221B6ED5CA9E6');
        $this->addSql('ALTER TABLE nnc_bill DROP FOREIGN KEY FK_148CB949A76ED395');
        $this->addSql('ALTER TABLE nnc_staging DROP FOREIGN KEY FK_6FDD3241A76ED395');
        $this->addSql('DROP TABLE nnc_bill');
        $this->addSql('DROP TABLE nnc_client');
        $this->addSql('DROP TABLE nnc_item');
        $this->addSql('DROP TABLE nnc_service');
        $this->addSql('DROP TABLE nnc_staging');
        $this->addSql('DROP TABLE nnc_user');
    }
}
