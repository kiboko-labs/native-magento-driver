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

    public function persist(ProductInterface $product)
    {
        if ($product->getId() === null) {
            $this->productQueue->enqueue($product);
        }

        $this->temporaryWriter->persistRow([
            'value_id'         => $product->getId(),
            'entity_type_id'   => 4,
            'attribute_set_id' => $product->getFamilyId(),
            'type_id'          => $product->getType(),
            'sku'              => $product->getIdentifier(),
            'has_options'      => $product->hasOptions(),
            'required_options' => $product->getRequiredOptions(),
            'created_at'       => $product->getCreationDate()->format(\DateTime::ISO8601),
            'updated_at'       => $product->getModificationDate()->format(\DateTime::ISO8601),
        ]);
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
