<?php

namespace unit\Luni\Component\MagentoDriver\DoctrineTools;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

trait DatabaseConnectionAwareTrait
{
    use \PHPUnit_Extensions_Database_TestCase_Trait;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    private $connection;

    /**
     * @var Connection
     */
    private $doctrineConnection;

    final public function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = $this->createDefaultDBConnection($this->getPdoConnection(), $GLOBALS['DB_NAME']);
        }

        return $this->connection;
    }

    /**
     * @return \PDO
     */
    private function getPdoConnection()
    {
        if ($this->pdo === null) {
            $dsn = sprintf('mysql:dbname=%s;hostname=%s;port=%s',
                isset($GLOBALS['DB_NAME'])     ? $GLOBALS['DB_NAME']     : 'magento',
                isset($GLOBALS['DB_HOSTNAME']) ? $GLOBALS['DB_HOSTNAME'] : '127.0.0.1',
                isset($GLOBALS['DB_PORT'])     ? $GLOBALS['DB_HOSTNAME'] : 3306
            );

            $this->pdo = new \PDO($dsn, $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'] );
        }

        return $this->pdo;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrineConnection()
    {
        if ($this->doctrineConnection === null) {
            $this->doctrineConnection = DriverManager::getConnection([
                'pdo' => $this->getPdoConnection()
            ]);
        }

        return $this->doctrineConnection;
    }
}
