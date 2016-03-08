<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Product;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Persister\ProductPersisterInterface;

class SimpleProductPersister
    implements ProductPersisterInterface
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
     * @param string $tableName
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

    /**
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product)
    {
        $this->dataQueue->push($product);
    }

    /**
     * @return void
     */
    public function flush()
    {
        foreach ($this->dataQueue as $product) {
            if ($product->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'entity_type_id'   => 4,
                        'attribute_set_id' => $product->getFamilyId(),
                        'type_id'          => $product->getType(),
                        'sku'              => $product->getIdentifier(),
                        'has_options'      => $product->hasOptions(),
                        'required_options' => $product->getRequiredOptions(),
                        'created_at'       => $product->getCreationDate()->format(\DateTime::ISO8601),
                        'updated_at'       => $product->getModificationDate()->format(\DateTime::ISO8601),
                    ],
                    [
                        'entity_id'        => $product->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id'   => 4,
                        'attribute_set_id' => $product->getFamilyId(),
                        'type_id'          => $product->getType(),
                        'sku'              => $product->getIdentifier(),
                        'has_options'      => $product->hasOptions(),
                        'required_options' => $product->getRequiredOptions(),
                        'created_at'       => $product->getCreationDate()->format(\DateTime::ISO8601),
                        'updated_at'       => $product->getModificationDate()->format(\DateTime::ISO8601),
                    ]
                );

                $product->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @return void
     */
    public function __invoke(ProductInterface $product)
    {
        $this->persist($product);
    }
}