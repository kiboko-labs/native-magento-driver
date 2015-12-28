<?php

namespace Luni\Component\MagentoDriver\AttributeBackend;

use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;

trait BaseAttributeCsvBackendTrait
{
    use AttributeBackendTrait;

    /**
     * @var array
     */
    private $keys = [
        'value_id',
        'entity_type_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'value',
    ];

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $path;

    /**
     * @var resource
     */
    protected $tmpFile;

    /**
     * @var string
     */
    private $delimiter = ';';

    /**
     * @var string
     */
    private $enclosure = '"';

    /**
     * @var string
     */
    private $escaper = '"';

    /**
     * Flushes data into the DB
     */
    public function flush()
    {
        if (!$this->tmpFile) {
            return;
        }

        if (false === fclose($this->tmpFile)) {
            throw new RuntimeErrorException(sprintf('Failed to close file %s', $this->getPath()));
        }

        $keys = [];
        foreach ($this->getKeys() as $key) {
            $keys[] = $this->connection->quoteIdentifier($key);
        }
        $serializedKeys = implode(',', $keys);

        $query =<<<SQL_EOF
LOAD DATA LOCAL INFILE {$this->connection->quote($this->tmpFile)}
REPLACE INTO TABLE {$this->connection->quoteIdentifier($this->table)}
FIELDS
    TERMINATED BY {$this->connection->quote($this->delimiter)}
    OPTIONALLY ENCLOSED BY {$this->connection->quote($this->enclosure)}
    ESCAPED BY {$this->connection->quote($this->escaper)}
({$serializedKeys})
SQL_EOF;

        if ($this->connection->exec($query) <= 0) {
            throw new RuntimeErrorException(sprintf('Failed to import data from file %s', $this->getPath()));
        }

        $this->localFs->remove($this->getPath());
    }

    private function persistRow(array $row)
    {
        if (false === fputcsv($this->tmpFile, $row, $this->delimiter, $this->enclosure)) {
            throw new RuntimeErrorException(sprintf('Failed to write to file %s', $this->getPath()));
        }
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
    }

    /**
     * @return string
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $escaper
     */
    public function setEscaper($escaper)
    {
        $this->escaper = $escaper;
    }
}