<?php

namespace Kiboko\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;

class AttributeLabelPersister implements AttributeLabelPersisterInterface
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

    public function flush()
    {
        foreach ($this->dataQueue as $attributeLabel) {
            $count = 0;
            if ($attributeLabel->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'attribute_id' => $attributeLabel->getAttributeId(),
                        'store_id' => $attributeLabel->getStoreId(),
                        'value' => $attributeLabel->getValue(),
                    ],
                    [
                        'attribute_label_id' => $attributeLabel->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'attribute_label_id' => $attributeLabel->getId(),
                        'attribute_id' => $attributeLabel->getAttributeId(),
                        'store_id' => $attributeLabel->getStoreId(),
                        'value' => $attributeLabel->getValue(),
                    ]
                );

                $attributeLabel->persistedToId($this->connection->lastInsertId());
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
