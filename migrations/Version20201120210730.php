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
        $table = $schema->createTable('images');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('file_name', 'string')->setNotnull(true);
        $table->addColumn('width', 'integer')->setUnsigned(true)->setNotnull(true);
        $table->addColumn('height', 'integer')->setUnsigned(true)->setNotnull(true);
        $table->addColumn('focal_point_x', 'integer')->setUnsigned(true)->setNotnull(true);
        $table->addColumn('focal_point_y', 'integer')->setUnsigned(true)->setNotnull(true);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('images');
    }
}
