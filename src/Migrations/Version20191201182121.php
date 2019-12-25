<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191201182121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE medcin (id INT AUTO_INCREMENT NOT NULL, services_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, INDEX IDX_B49ACC86AEF5A6C1 (services_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medcin_specialite (medcin_id INT NOT NULL, specialite_id INT NOT NULL, INDEX IDX_744D0DB7F46C40AE (medcin_id), INDEX IDX_744D0DB72195E0F0 (specialite_id), PRIMARY KEY(medcin_id, specialite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medcin ADD CONSTRAINT FK_B49ACC86AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE medcin_specialite ADD CONSTRAINT FK_744D0DB7F46C40AE FOREIGN KEY (medcin_id) REFERENCES medcin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medcin_specialite ADD CONSTRAINT FK_744D0DB72195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE medcin_specialite DROP FOREIGN KEY FK_744D0DB7F46C40AE');
        $this->addSql('ALTER TABLE medcin DROP FOREIGN KEY FK_B49ACC86AEF5A6C1');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2ED5CA9E6');
        $this->addSql('ALTER TABLE medcin_specialite DROP FOREIGN KEY FK_744D0DB72195E0F0');
        $this->addSql('DROP TABLE medcin');
        $this->addSql('DROP TABLE medcin_specialite');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE specialite');
    }
}
