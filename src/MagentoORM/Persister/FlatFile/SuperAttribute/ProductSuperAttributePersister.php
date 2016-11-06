<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\SuperAttribute;

use Kiboko\Component\MagentoORM\Model\SuperAttributeInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\BaseFlatFilePersisterTrait;
use Kiboko\Component\MagentoORM\Persister\SuperAttribute\SuperAttributePersisterInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;

class ProductSuperAttributePersister implements SuperAttributePersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @var \SplQueue
     */
    private $superAttributeQueue;

    /**
     * @param TemporaryWriterInterface $temporaryWriter
     * @param DatabaseWriterInterface  $databaseWriter
     * @param string                   $tableName
     * @param array                    $tableKeys
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
        $this->superAttributeQueue = new \SplQueue();
    }

    public function initialize()
    {
    }

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function persist(SuperAttributeInterface $superAttribute)
    {
        if ($superAttribute->getId() === null) {
            $this->superAttributeQueue->enqueue($superAttribute);
        }

        $this->temporaryWriter->persistRow([
            'catalog_product_super_attribute_id' => $superAttribute->getId(),
            'product_id' => $superAttribute->getProductId(),
            'attribute_id' => $superAttribute->getAttributeId(),
            'position' => $superAttribute->getPosition(),
        ]);
    }

    /**
     * @param SuperAttributeInterface $superAttribute
     */
    public function __invoke(SuperAttributeInterface $superAttribute)
    {
        $this->persist($superAttribute);
    }

    public function flush()
    {
        $this->doFlush();
    }

    /**
     * @return \Generator
     */
    protected function walkQueue()
    {
        while ($this->superAttributeQueue->count() > 0 && $identifier = yield) {
            /** @var SuperAttributeInterface $superAttribute */
            $superAttribute = $this->superAttributeQueue->dequeue();
            $superAttribute->persistedToId($identifier);
        }
    }
}
