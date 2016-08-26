<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

class AttributeLabelPersister implements AttributeLabelPersisterInterface
{
    use InsertUpdateAwareTrait;
    
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var \SplQueue
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
     * @param AttributeLabelInterface $attributeLabel
     */
    public function persist(AttributeLabelInterface $attributeLabel)
    {
        $this->dataQueue->push($attributeLabel);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $attributeLabel) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'attribute_label_id' => $attributeLabel->getId(),
                    'attribute_id' => $attributeLabel->getAttributeId(),
                    'store_id' => $attributeLabel->getStoreId(),
                    'value' => $attributeLabel->getValue(),
                ],
                [
                    'attribute_id',
                    'store_id',
                    'value',
                ]
            );

            if ($attributeLabel->getId() === null) {
                $attributeLabel->persistedToId($this->connection->lastInsertId());
                yield $attributeLabel;
            }
        }
    }

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function __invoke(AttributeLabelInterface $attributeLabel)
    {
        $this->persist($attributeLabel);
    }
}
