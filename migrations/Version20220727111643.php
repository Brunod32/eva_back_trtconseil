<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727111643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_58DF0651E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, job_offer_id INT DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, INDEX IDX_D930569D91BD8781 (candidate_id), INDEX IDX_D930569D3481D195 (job_offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, cv VARCHAR(255) DEFAULT NULL, is_valid TINYINT(1) NOT NULL, job VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_C8B28E44E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_441282A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, consultant_id INT DEFAULT NULL, recruiter_id INT DEFAULT NULL, job_title VARCHAR(30) NOT NULL, workplace VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, is_valid TINYINT(1) NOT NULL, salary INT NOT NULL, schedule INT NOT NULL, INDEX IDX_288A3A4E44F779A2 (consultant_id), INDEX IDX_288A3A4E156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruiter (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company_name VARCHAR(30) DEFAULT NULL, company_address VARCHAR(100) DEFAULT NULL, is_valid TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DE8633D8E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D3481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D91BD8781');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E44F779A2');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D3481D195');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E156BE243');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE candidacy');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP TABLE recruiter');
    }
}
