<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114185102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `actor` (id VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', link VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, seasons_active JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_character (actor_id VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_id VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6703401810DAF24A (actor_id), INDEX IDX_670340181136BE75 (character_id), PRIMARY KEY(actor_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', link VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, royal TINYINT(1) NOT NULL, kingsguard TINYINT(1) NOT NULL, image_thumb VARCHAR(255) NULL, image_full VARCHAR(255) NULL, houses JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_allies (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_F797F0C7FCC8BCE0 (character_source), INDEX IDX_F797F0C7E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_married_engaged (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_D74EB6AEFCC8BCE0 (character_source), INDEX IDX_D74EB6AEE52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_siblings (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_5B0BF371FCC8BCE0 (character_source), INDEX IDX_5B0BF371E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_guards (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B73C4324FCC8BCE0 (character_source), INDEX IDX_B73C4324E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_parents (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B5DC6431FCC8BCE0 (character_source), INDEX IDX_B5DC6431E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_serves (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1325F5C7FCC8BCE0 (character_source), INDEX IDX_1325F5C7E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_kills (character_source VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', character_target VARCHAR(255) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E004346FCC8BCE0 (character_source), INDEX IDX_E004346E52DEC6F (character_target), PRIMARY KEY(character_source, character_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_character ADD CONSTRAINT FK_6703401810DAF24A FOREIGN KEY (actor_id) REFERENCES `actor` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_character ADD CONSTRAINT FK_670340181136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_allies ADD CONSTRAINT FK_F797F0C7FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_allies ADD CONSTRAINT FK_F797F0C7E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_married_engaged ADD CONSTRAINT FK_D74EB6AEFCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_married_engaged ADD CONSTRAINT FK_D74EB6AEE52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_siblings ADD CONSTRAINT FK_5B0BF371FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_siblings ADD CONSTRAINT FK_5B0BF371E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_guards ADD CONSTRAINT FK_B73C4324FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_guards ADD CONSTRAINT FK_B73C4324E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_parents ADD CONSTRAINT FK_B5DC6431FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_parents ADD CONSTRAINT FK_B5DC6431E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_serves ADD CONSTRAINT FK_1325F5C7FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_serves ADD CONSTRAINT FK_1325F5C7E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_kills ADD CONSTRAINT FK_E004346FCC8BCE0 FOREIGN KEY (character_source) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_kills ADD CONSTRAINT FK_E004346E52DEC6F FOREIGN KEY (character_target) REFERENCES `character` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE actor_character DROP FOREIGN KEY FK_6703401810DAF24A');
        $this->addSql('ALTER TABLE actor_character DROP FOREIGN KEY FK_670340181136BE75');
        $this->addSql('ALTER TABLE characters_allies DROP FOREIGN KEY FK_F797F0C7FCC8BCE0');
        $this->addSql('ALTER TABLE characters_allies DROP FOREIGN KEY FK_F797F0C7E52DEC6F');
        $this->addSql('ALTER TABLE characters_married_engaged DROP FOREIGN KEY FK_D74EB6AEFCC8BCE0');
        $this->addSql('ALTER TABLE characters_married_engaged DROP FOREIGN KEY FK_D74EB6AEE52DEC6F');
        $this->addSql('ALTER TABLE characters_siblings DROP FOREIGN KEY FK_5B0BF371FCC8BCE0');
        $this->addSql('ALTER TABLE characters_siblings DROP FOREIGN KEY FK_5B0BF371E52DEC6F');
        $this->addSql('ALTER TABLE characters_guards DROP FOREIGN KEY FK_B73C4324FCC8BCE0');
        $this->addSql('ALTER TABLE characters_guards DROP FOREIGN KEY FK_B73C4324E52DEC6F');
        $this->addSql('ALTER TABLE characters_parents DROP FOREIGN KEY FK_B5DC6431FCC8BCE0');
        $this->addSql('ALTER TABLE characters_parents DROP FOREIGN KEY FK_B5DC6431E52DEC6F');
        $this->addSql('ALTER TABLE characters_serves DROP FOREIGN KEY FK_1325F5C7FCC8BCE0');
        $this->addSql('ALTER TABLE characters_serves DROP FOREIGN KEY FK_1325F5C7E52DEC6F');
        $this->addSql('ALTER TABLE characters_kills DROP FOREIGN KEY FK_E004346FCC8BCE0');
        $this->addSql('ALTER TABLE characters_kills DROP FOREIGN KEY FK_E004346E52DEC6F');
        $this->addSql('DROP TABLE `actor`');
        $this->addSql('DROP TABLE actor_character');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE characters_allies');
        $this->addSql('DROP TABLE characters_married_engaged');
        $this->addSql('DROP TABLE characters_siblings');
        $this->addSql('DROP TABLE characters_guards');
        $this->addSql('DROP TABLE characters_parents');
        $this->addSql('DROP TABLE characters_serves');
        $this->addSql('DROP TABLE characters_kills');
    }
}
