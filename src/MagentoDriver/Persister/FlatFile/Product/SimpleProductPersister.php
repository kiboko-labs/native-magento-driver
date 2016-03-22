<?php

namespace Luni\Component\MagentoDriver\Persister\FlatFile\Product;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Persister\BaseFlatFilePersisterTrait;
use Luni\Component\MagentoDriver\Persister\ProductPersisterInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class SimpleProductPersister implements ProductPersisterInterface
{
    use BaseFlatFilePersisterTrait;

    /**
     * @var \SplQueue
     */
    private $productQueue;

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
        $this->productQueue = new \SplQueue();
    }

    public function initialize()
    {
    }

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product)
    {
        if ($product->getId() === null) {
            $this->productQueue->enqueue($product);
        }

        $this->temporaryWriter->persistRow([
            'entity_id' => $product->getId(),
            'entity_type_id' => 4,
            'attribute_set_id' => $product->getFamilyId(),
            'type_id' => $product->getType(),
            'sku' => $product->getIdentifier(),
            'has_options' => $product->hasOptions(),
            'required_options' => $product->getRequiredOptions(),
            'created_at' => $product->getCreationDate()->format(\DateTime::ISO8601),
            'updated_at' => $product->getModificationDate()->format(\DateTime::ISO8601),
        ]);
    }

    /**
     * @param ProductInterface $product
     */
    public function __invoke(ProductInterface $product)
    {
        $this->persist($product);
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
        while ($this->productQueue->count() > 0 && $id = yield) {
            /** @var ProductInterface $product */
            $product = $this->productQueue->dequeue();
            $product->persistedToId($id);
        }
    }
}
