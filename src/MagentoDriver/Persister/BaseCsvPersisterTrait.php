<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

trait BaseCsvPersisterTrait
{
    /**
     * @var TemporaryWriterInterface
     */
    private $temporaryWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $databaseWriter;

    /**
     * @var array
     */
    private $tableKeys = [];

    /**
     * @var string
     */
    private $tableName;

    /**
     * Flushes data into the DB
     */
    public function doFlush()
    {
        $this->temporaryWriter->flush();

        $this->databaseWriter->write($this->getTableName(), $this->getTableKeys(), $this->walkQueue());
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    protected function getTableKeys()
    {
        return $this->tableKeys;
    }

    /**
     * @return \Generator
     */
    abstract protected function walkQueue();
}
