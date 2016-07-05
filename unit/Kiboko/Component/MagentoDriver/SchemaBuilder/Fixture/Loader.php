<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;
use Symfony\Component\Yaml\Yaml;

class Loader implements LoaderInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $magentoVersion;

    /**
     * @var string
     */
    private $magentoEdition;

    /**
     * Magento EE and CE version equivalents
     *
     * @var array
     */
    private $magentoVersionMapping = [
        '1.6'  => '1.4',
        '1.7'  => '1.4',
        '1.8'  => '1.4',
        '1.9'  => '1.4',
        '1.10' => '1.5',
        '1.11' => '1.6',
        '1.12' => '1.7',
        '1.13' => '1.8',
        '1.14' => '1.9',
    ];

    /**
     * @param Connection $connection
     * @param string $magentoVersion
     * @param string $magentoEdition
     */
    public function __construct(
        Connection $connection,
        $magentoVersion,
        $magentoEdition
    ) {
        $this->connection = $connection;
        $this->magentoVersion = $magentoVersion;
        $this->magentoEdition = $magentoEdition;
    }

    /**
     * @param string $file
     * @param string $magentoVersion
     * @param string $magentoEdition
     * @return string
     */
    protected function fixturesFile($file, $magentoVersion, $magentoEdition)
    {
        return __DIR__ . sprintf('/../fixture/data-%s-%s/%s', strtolower($magentoEdition), $magentoVersion, $file);
    }

    /**
     * @param string $file
     * @param string $magentoVersion
     * @param string $magentoEdition
     * @return string
     */
    protected function fixturesFallback($file, $magentoVersion, $magentoEdition)
    {
        $path = $this->fixturesFile($file, $magentoVersion, $magentoEdition);
        if (!file_exists($path)) {
            if (strtolower($magentoEdition) === 'ee' && isset($this->magentoVersionMapping[$magentoVersion])) {
                $path = $this->fixturesFile($file, $this->magentoVersionMapping[$magentoVersion], 'ce');
            }

            if (!file_exists($path)) {
                throw new \PHPUnit_Framework_ExpectationFailedException(sprintf(
                    'Missing fixtures for Magento %s %s', $magentoVersion, strtoupper($magentoEdition)));
            }
        }

        return $path;
    }

    /**
     * @return string
     */
    protected function getPathname()
    {
        return $this->fixturesFallback('dataset.yml', $this->magentoVersion, $this->magentoEdition);
    }

    public function loadFixtures()
    {
        // TODO: Implement loadFixtures() method.
    }

    /**
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function expectedDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getPathname());
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function hydrate($table)
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
            foreach ($this->walkData($table) as $thisLine) {
                $this->connection->insert(
                    $table,
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
                $table, $this->getPathname()), null, $e);
        }
        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', $originalModes)
            ));
        }

        return $this;
    }

    /**
     * @param string $table
     *
     * @return \Generator
     */
    public function walkData($table)
    {
        $yaml = new Yaml();

        $data = $yaml->parse(file_get_contents($this->getPathname()));
        if (!isset($data[$table]) || !is_array($data[$table])) {
            throw new \PHPUnit_Framework_SkippedTestError(
                sprintf('No fixtures for table "%s".', $table));
        }

        foreach ($data[$table] as $thisLine) {
            yield $thisLine;
        }
    }
}
