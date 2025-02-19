<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219150044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address1 VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, postalcode VARCHAR(50) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrousel (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, position INT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_details (cart_id INT NOT NULL, product_id INT NOT NULL, package_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_89FCC38D1AD5CDBF (cart_id), INDEX IDX_89FCC38D4584665A (product_id), INDEX IDX_89FCC38DF44CABFF (package_id), PRIMARY KEY(cart_id, product_id, package_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config (keyy VARCHAR(50) NOT NULL, value LONGTEXT NOT NULL, PRIMARY KEY(keyy)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, address_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, date DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, status VARCHAR(50) NOT NULL, invoice_number VARCHAR(50) NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F5299398F5B7AF75 (address_id), INDEX IDX_F52993984C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, number VARCHAR(50) NOT NULL, expiration_date VARCHAR(7) NOT NULL, cvv VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, details LONGTEXT NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, path LONGTEXT NOT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, package_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_6B9459854584665A (product_id), INDEX IDX_6B945985F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, order_id INT DEFAULT NULL, package_id INT DEFAULT NULL, subscription_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, quantity INT NOT NULL, INDEX IDX_A3C664D34584665A (product_id), INDEX IDX_A3C664D3A76ED395 (user_id), INDEX IDX_A3C664D38D9F6D38 (order_id), INDEX IDX_A3C664D3F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE top_products (id INT AUTO_INCREMENT NOT NULL, services_id INT DEFAULT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, INDEX IDX_128F9016AEF5A6C1 (services_id), UNIQUE INDEX UNIQ_128F90163DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, is_valid TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_address (user_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_5543718BA76ED395 (user_id), INDEX IDX_5543718BF5B7AF75 (address_id), PRIMARY KEY(user_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_payment_mode (user_id INT NOT NULL, method_id INT NOT NULL, INDEX IDX_3685ACDDA76ED395 (user_id), INDEX IDX_3685ACDD19883967 (method_id), PRIMARY KEY(user_id, method_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_details ADD CONSTRAINT FK_89FCC38D1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_details ADD CONSTRAINT FK_89FCC38D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_details ADD CONSTRAINT FK_89FCC38DF44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment_method (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B9459854584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B945985F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE top_products ADD CONSTRAINT FK_128F9016AEF5A6C1 FOREIGN KEY (services_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE top_products ADD CONSTRAINT FK_128F90163DA5256D FOREIGN KEY (image_id) REFERENCES product_image (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user_payment_mode ADD CONSTRAINT FK_3685ACDDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_payment_mode ADD CONSTRAINT FK_3685ACDD19883967 FOREIGN KEY (method_id) REFERENCES payment_method (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_details DROP FOREIGN KEY FK_89FCC38D1AD5CDBF');
        $this->addSql('ALTER TABLE cart_details DROP FOREIGN KEY FK_89FCC38D4584665A');
        $this->addSql('ALTER TABLE cart_details DROP FOREIGN KEY FK_89FCC38DF44CABFF');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F5B7AF75');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984C3A3BB');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B9459854584665A');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B945985F44CABFF');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D34584665A');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D38D9F6D38');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3F44CABFF');
        $this->addSql('ALTER TABLE top_products DROP FOREIGN KEY FK_128F9016AEF5A6C1');
        $this->addSql('ALTER TABLE top_products DROP FOREIGN KEY FK_128F90163DA5256D');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BA76ED395');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BF5B7AF75');
        $this->addSql('ALTER TABLE user_payment_mode DROP FOREIGN KEY FK_3685ACDDA76ED395');
        $this->addSql('ALTER TABLE user_payment_mode DROP FOREIGN KEY FK_3685ACDD19883967');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE carrousel');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_price');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE top_products');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('DROP TABLE user_payment_mode');
    }
}
