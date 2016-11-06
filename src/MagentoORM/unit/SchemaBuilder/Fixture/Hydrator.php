<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;
use Symfony\Component\Yaml\Yaml;

class Hydrator implements HydratorInterface
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
     * @var FallbackResolver
     */
    private $fallbackResolver;

    /**
     * @param Connection       $connection
     * @param FallbackResolver $resolver
     * @param string           $magentoVersion
     * @param string           $magentoEdition
     */
    public function __construct(
        Connection $connection,
        FallbackResolver $resolver,
        $magentoVersion,
        $magentoEdition
    ) {
        $this->connection = $connection;
        $this->fallbackResolver = $resolver;
        $this->magentoVersion = $magentoVersion;
        $this->magentoEdition = $magentoEdition;
    }

    /**
     * @param string $suite
     * @param string $context
     *
     * @return string
     */
    protected function getPathname($suite, $context)
    {
        return $this->fallbackResolver->find('initial', $suite, $context,
            $this->magentoVersion, $this->magentoEdition);
    }

    /**
     * @param string $table
     * @param string $suite
     * @param string $context
     *
     * @return $this
     */
    public function hydrate($table, $suite, $context)
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
            foreach ($this->walkData($table, $suite, $context) as $thisLine) {
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
                $table, $this->getPathname($suite, $context)), null, $e);
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
     * @param string $suite
     * @param string $context
     *
     * @return \Traversable
     */
    public function walkData($table, $suite, $context)
    {
        $yaml = new Yaml();

        $data = $yaml->parse(file_get_contents($this->getPathname($suite, $context)));
        if (!isset($data[$table]) || !is_array($data[$table])) {
            throw new \PHPUnit_Framework_SkippedTestError(
                sprintf('No fixtures for table "%s".', $table));
        }

        foreach ($data[$table] as $thisLine) {
            yield $thisLine;
        }
    }
}
