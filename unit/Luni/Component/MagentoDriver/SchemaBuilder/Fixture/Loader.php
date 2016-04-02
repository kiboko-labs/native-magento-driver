<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;

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
        return __DIR__.sprintf('/data-%s-%s/%s.csv', $magentoEdition, $magentoVersion, $this->tableName);
    }

    /**
     * @param string $magentoVersion
     * @param string $magentoEdition
     * @return $this
     */
    public function hydrate($magentoVersion, $magentoEdition = 'ce')
    {
        $file = new \SplFileObject($this->getPathname($magentoVersion, $magentoEdition), 'r');

        $statement = $this->connection
            ->executeQuery('SELECT @@SESSION.sql_mode');
        $statement->execute();
        $originalModes = explode(',', $statement->fetchColumn());
        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', array_merge($originalModes, ['NO_AUTO_VALUE_ON_ZERO']))
            ));
        }

        $firstLine = $file->fgetcsv(',', '"', '"');
        $columnCount = count($firstLine);
        try {
            while (!$file->eof()) {
                $thisLine = $file->fgetcsv(',', '"', '"');

                if (count($thisLine) !== $columnCount) {
                    continue;
                }

                $this->connection->insert(
                    $this->tableName,
                    array_combine($firstLine, $thisLine)
                );
            }
        } catch (\Exception $e) {
            if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
                $this->connection->exec(sprintf('SET SESSION sql_mode=%s',
                    implode(',', $originalModes)
                ));
            }

            throw new \RuntimeException(sprintf(
                'Failed to import fixtures from file %s', $file->getPathname()), $e);
        }

        return $this;
    }

    /**
     * @param $magentoEdition
     * @param $magentoVersion
     * @param int $offset
     * @param int $count
     *
     * @return \Generator
     */
    public function walkData($magentoEdition, $magentoVersion, $offset = 0, $count = null)
    {
        $file = new \SplFileObject($this->getPathname($magentoEdition, $magentoVersion), 'r');

        $firstLine = $file->fgetcsv(',', '"', '"');
        $columnCount = count($firstLine);
        $currentLine = 0;
        $readLines = 0;
        while (!$file->eof()) {
            $thisLine = $file->fgetcsv(',', '"', '"');
            if ($currentLine < $offset) {
                continue;
            }

            if ($count !== null && ++$readLines >= $count) {
                break;
            }

            if (count($thisLine) !== $columnCount) {
                continue;
            }

            yield array_combine($firstLine, $thisLine);
        }
    }

    /**
     * @param $magentoEdition
     * @param $magentoVersion
     * @param int $offset
     *
     * @return \Generator
     */
    public function readData($magentoEdition, $magentoVersion, $offset = 0)
    {
        $file = new \SplFileObject($this->getPathname($magentoEdition, $magentoVersion), 'r');

        $firstLine = $file->fgetcsv(',', '"', '"');
        $columnCount = count($firstLine);
        $currentLine = 0;
        $readLines = 0;
        while (!$file->eof()) {
            $thisLine = $file->fgetcsv(',', '"', '"');
            if ($currentLine < $offset) {
                continue;
            }

            if (count($thisLine) !== $columnCount) {
                continue;
            }

            return array_combine($firstLine, $thisLine);
        }

        throw new \RuntimeException(sprintf('No fixture at offset %d in table %s.', $offset, $this->tableName));
    }
}
