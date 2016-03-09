<?php

namespace unit\Luni\Component\MagentoDriver\DoctrineTools;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

trait DatabaseConnectionAwareTrait
{
    /**
     * @var Connection
     */
    private $connection;


    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function initConnection()
    {
        $this->connection = DriverManager::getConnection(
            [
                'driver'   => isset($GLOBALS['DB_DRIVER'])   ? $GLOBALS['DB_DRIVER']   : 'mysqli',
                'dbname'   => isset($GLOBALS['DB_NAME'])     ? $GLOBALS['DB_NAME']     : 'magento',
                'user'     => isset($GLOBALS['DB_USERNAME']) ? $GLOBALS['DB_USERNAME'] : 'magento',
                'password' => isset($GLOBALS['DB_PASSWORD']) ? $GLOBALS['DB_PASSWORD'] : 'password',
                'host'     => isset($GLOBALS['DB_HOSTNAME']) ? $GLOBALS['DB_HOSTNAME'] : '127.0.0.1',
                'port'     => isset($GLOBALS['DB_PORT'])     ? $GLOBALS['DB_HOSTNAME'] : 3306,
            ]
        );
    }

    protected function closeConnection()
    {
        $this->connection->close();
        $this->connection = null;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}