<?php

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotEnv->load();
return[
    'paths' => [
        'migrations' => __DIR__.'/_data/db/migrations',
        'seeds' => __DIR__.'/_data/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'ut_migrations',
        'default_database' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => getenv('CRM_MYSQL_HOST'),
            'name' => getenv('CRM_MYSQL_NAME'),
            'user' => getenv('CRM_MYSQL_USER'),
            'pass' => getenv('CRM_MYSQL_PASS'),
            'port' => 3306,
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('CRM_MYSQL_HOST'),
            'name' => getenv('CRM_MYSQL_NAME'),
            'user' => getenv('CRM_MYSQL_USER'),
            'pass' => getenv('CRM_MYSQL_PASS'),
            'port' => 3306,
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation',
];
