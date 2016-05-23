<?php

namespace Kiboko\Component\MagentoDriver\Persister\Direct\Product;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Persister\ProductPersisterInterface;

class SimpleProductPersister implements ProductPersisterInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var \SplQueue|ProductInterface[]
     */
    private $dataQueue;

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
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    public function initialize()
    {
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product)
    {
        $this->dataQueue->push($product);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $product) {
            $count = 0;
            if ($product->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'entity_type_id' => 4,
                        'attribute_set_id' => $product->getFamilyId(),
                        'type_id' => $product->getType(),
                        'sku' => $product->getIdentifier(),
                        'has_options' => $product->hasOptions(),
                        'required_options' => $product->getRequiredOptions(),
                        'created_at' => $product->getCreationDate()->format(\DateTime::ISO8601),
                        'updated_at' => $product->getModificationDate()->format(\DateTime::ISO8601),
                    ],
                    [
                        'entity_id' => $product->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'entity_id' => $product->getId(),
                        'entity_type_id' => 4,
                        'attribute_set_id' => $product->getFamilyId(),
                        'type_id' => $product->getType(),
                        'sku' => $product->getIdentifier(),
                        'has_options' => $product->hasOptions(),
                        'required_options' => $product->getRequiredOptions(),
                        'created_at' => $product->getCreationDate()->format(\DateTime::ISO8601),
                        'updated_at' => $product->getModificationDate()->format(\DateTime::ISO8601),
                    ]
                );

                $product->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param ProductInterface $product
     */
    public function __invoke(ProductInterface $product)
    {
        $this->persist($product);
    }
}
