<?php

declare(strict_types=1);

namespace Kanvas\Guild\Providers;

use Exception;
use PDO;
use PDOException;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class Database implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container) : void
    {
        $container->setShared(
            'dbCRM',
            function () {
                $options = [
                    'host' => getenv('GUILD_MYSQL_HOST'),
                    'username' => getenv('GUILD_MYSQL_USER'),
                    'password' => getenv('GUILD_MYSQL_PASS'),
                    'dbname' => getenv('GUILD_MYSQL_NAME'),
                    'charset' => 'utf8',
                    'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]
                ];

                try {
                    $connection = new Mysql($options);

                    // Set everything to UTF8
                    $connection->execute('SET NAMES utf8mb4', []);
                } catch (PDOException $e) {
                    throw new Exception($e->getMessage());
                }

                return $connection;
            }
        );
    }
}
