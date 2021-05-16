<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516131656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates the products table';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE product (style_number VARCHAR(7) NOT NULL, name VARCHAR(255) NOT NULL, currency VARCHAR(3) NOT NULL, amount INTEGER NOT NULL, images CLOB NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(style_number));');
        $this->addSql('CREATE INDEX IDX_product_status ON product (status);');
        /*
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL);');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name);');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at);');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at);');
        */
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product;');
        //$this->addSql('DROP TABLE messenger_messages;');
    }
}
