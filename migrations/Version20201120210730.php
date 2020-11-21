<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201120210730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates the images table.';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE images (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                file_name VARCHAR(255) UNIQUE NOT NULL,
                width INT(11) NOT NULL,
                height INT(11) NOT NULL,
                focal_point_x INT(11) NOT NULL,
                focal_point_y INT(11) NOT NULL
            );
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS images');
    }
}
