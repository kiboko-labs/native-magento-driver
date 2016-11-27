<?php

namespace unit\Kiboko\Component\MagentoORM\DoctrineTools;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;

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

    /**
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection|\PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    final public function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = $this->createDefaultDBConnection(
                $this->getPdoConnection(),
                isset($GLOBALS['DB_NAME']) ? $GLOBALS['DB_NAME'] : 'test'
            );
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
                isset($GLOBALS['DB_NAME']) ? $GLOBALS['DB_NAME'] : 'test',
                isset($GLOBALS['DB_HOSTNAME']) ? $GLOBALS['DB_HOSTNAME'] : '127.0.0.1',
                isset($GLOBALS['DB_PORT']) ? $GLOBALS['DB_PORT'] : 3306
            );

            $this->pdo = new \PDO(
                $dsn,
                isset($GLOBALS['DB_USERNAME']) ? $GLOBALS['DB_USERNAME'] : 'root',
                isset($GLOBALS['DB_PASSWORD']) ? $GLOBALS['DB_PASSWORD'] : null
            );
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
                'pdo' => $this->getPdoConnection(),
            ]);
            $this->doctrineConnection->getDatabasePlatform()
                ->registerDoctrineTypeMapping('enum', 'string');
        }

        return $this->doctrineConnection;
    }

    /**
     * @return Loader
     */
    public function getFixturesLoader()
    {
        return $this->fixturesLoader;
    }
}
