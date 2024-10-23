<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241023130117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line (order_id INT NOT NULL, user_id INT NOT NULL, sandwich_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(order_id, user_id, sandwich_id))');
        $this->addSql('CREATE INDEX IDX_9CE58EE18D9F6D38 ON order_line (order_id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE1A76ED395 ON order_line (user_id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE14D566043 ON order_line (sandwich_id)');
        $this->addSql('CREATE TABLE sandwich (id SERIAL NOT NULL, label VARCHAR(255) NOT NULL, unit_price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14D566043 FOREIGN KEY (sandwich_id) REFERENCES sandwich (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE order_line DROP CONSTRAINT FK_9CE58EE18D9F6D38');
        $this->addSql('ALTER TABLE order_line DROP CONSTRAINT FK_9CE58EE1A76ED395');
        $this->addSql('ALTER TABLE order_line DROP CONSTRAINT FK_9CE58EE14D566043');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE sandwich');
    }
}
