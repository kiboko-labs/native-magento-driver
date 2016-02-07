<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Entity\ProductInterface;
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
     * @var \SplQueue
     */
    private $productQueue;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface $databaseWriter
     * @param string $tableName
     * @param array $tableKeys
     */
    public function __construct(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter,
        $tableName,
        array $tableKeys = []
    ) {
        $this->temporaryWriter = $temporaryWriter;
        $this->databaseWriter = $databaseWriter;
        $this->tableName = $tableName;
        $this->tableKeys = $tableKeys;
        $this->productQueue = new \SplQueue();
    }

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
    private function walkQueue()
    {
        while ($this->productQueue->count() > 0 && $id = yield) {
            /** @var ProductInterface $product */
            $product = $this->productQueue->dequeue();
            $product->persistedToId($id);
        }
    }
}
