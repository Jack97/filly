<?php

use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command as MigrationCommand;
use Silex\Application;
use Symfony\Component\Console\Application as Console;

/** @var Application $app */

$console = new Console();
$console->setDispatcher($app['dispatcher']);

$dependencyFactory = DependencyFactory::fromConnection(
    new PhpFile(__DIR__ . '/../config/migrations.php'),
    new ExistingConnection($app['db'])
);

$migrationCommands = [
    MigrationCommand\CurrentCommand::class,
    MigrationCommand\DumpSchemaCommand::class,
    MigrationCommand\ExecuteCommand::class,
    MigrationCommand\GenerateCommand::class,
    MigrationCommand\LatestCommand::class,
    MigrationCommand\ListCommand::class,
    MigrationCommand\MigrateCommand::class,
    MigrationCommand\RollupCommand::class,
    MigrationCommand\StatusCommand::class,
    MigrationCommand\SyncMetadataCommand::class,
    MigrationCommand\UpToDateCommand::class,
    MigrationCommand\VersionCommand::class,
];

foreach ($migrationCommands as $command) {
    $console->add(new $command($dependencyFactory));
}

return $console;
