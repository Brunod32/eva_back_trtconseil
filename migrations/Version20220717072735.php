<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717072735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidacy_candidate');
        $this->addSql('ALTER TABLE candidacy ADD candidate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('CREATE INDEX IDX_D930569D91BD8781 ON candidacy (candidate_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy_candidate (candidacy_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_BA5011759B22434 (candidacy_id), INDEX IDX_BA5011791BD8781 (candidate_id), PRIMARY KEY(candidacy_id, candidate_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE candidacy_candidate ADD CONSTRAINT FK_BA5011759B22434 FOREIGN KEY (candidacy_id) REFERENCES candidacy (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidacy_candidate ADD CONSTRAINT FK_BA5011791BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D91BD8781');
        $this->addSql('DROP INDEX IDX_D930569D91BD8781 ON candidacy');
        $this->addSql('ALTER TABLE candidacy DROP candidate_id');
    }
}
