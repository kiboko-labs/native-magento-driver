<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

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
     * Flushes data into the DB.
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
     * @return \Traversable
     */
    abstract protected function walkQueue();
}
