<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;
use Symfony\Component\Yaml\Yaml;

class Loader
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @param Connection $connection
     * @param string     $tableName
     */
    public function __construct(
        Connection $connection,
        $tableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     *
     * @return string
     */
    private function getPathname($magentoVersion, $magentoEdition)
    {
        return __DIR__.sprintf('/../../fixture/data-%s-%s/dataset.yml', $magentoEdition, $magentoVersion);
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     *
     * @return $this
     */
    public function hydrate($magentoVersion, $magentoEdition = 'ce')
    {
        $statement = $this->connection
            ->executeQuery('SELECT @@SESSION.sql_mode');
        $statement->execute();
        $originalModes = explode(',', $statement->fetchColumn());
        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', array_merge($originalModes, ['NO_AUTO_VALUE_ON_ZERO']))
            ));
        }

        try {
            foreach ($this->walkData($magentoVersion, $magentoEdition) as $thisLine) {
                $this->connection->insert(
                    $this->tableName,
                    $thisLine
                );
            }
        } catch (\Exception $e) {
            if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
                $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                    implode(',', $originalModes)
                ));
            }

            throw new \PHPUnit_Framework_SkippedTestError(sprintf(
                'Failed to import table %s fixtures from file %s',
                $this->tableName, $this->getPathname($magentoVersion, $magentoEdition)), null, $e);
        }
        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', $originalModes)
            ));
        }

        return $this;
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     *
     * @return \Generator
     */
    public function walkData($magentoVersion, $magentoEdition)
    {
        $yaml = new Yaml();

        $data = $yaml->parse(file_get_contents($this->getPathname($magentoVersion, $magentoEdition)));
        if (!isset($data[$this->tableName]) || !is_array($data[$this->tableName])) {
            throw new \PHPUnit_Framework_SkippedTestError(
                sprintf('No fixtures for table "%s".', $this->tableName));
        }

        foreach ($data[$this->tableName] as $thisLine) {
            yield $thisLine;
        }
    }
}
