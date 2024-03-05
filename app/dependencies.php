<?php

declare(strict_types=1);

use App\Application\Console\ImportPostalCodesCommand;
use App\Application\Database\DatabaseInterface;
use App\Application\Database\PDODatabase;
use App\Application\Settings\SettingsInterface;
use App\Domain\PostalCode\PostalCodeRepository;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        DatabaseInterface::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $databaseSettings = $settings->get('database');

            return new PDODatabase(...$databaseSettings['pdo']);
        },

        ImportPostalCodesCommand::class => function (ContainerInterface $container) {
            return new ImportPostalCodesCommand($container->get(PostalCodeRepository::class));
        },
    ]);
};