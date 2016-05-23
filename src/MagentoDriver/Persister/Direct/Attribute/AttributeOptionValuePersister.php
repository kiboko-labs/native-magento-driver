<?php

namespace Kiboko\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionValuePersisterInterface;

class AttributeOptionValuePersister implements AttributeOptionValuePersisterInterface
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
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function persist(AttributeOptionValueInterface $attributeOptionValue)
    {
        $this->dataQueue->push($attributeOptionValue);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $attributeOptionValue) {
            $count = 0;
            if ($attributeOptionValue->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'option_id' => $attributeOptionValue->getOptionId(),
                        'store_id' => $attributeOptionValue->getStoreId(),
                        'value' => $attributeOptionValue->getValue(),
                    ],
                    [
                        'value_id' => $attributeOptionValue->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'value_id' => $attributeOptionValue->getId(),
                        'option_id' => $attributeOptionValue->getOptionId(),
                        'store_id' => $attributeOptionValue->getStoreId(),
                        'value' => $attributeOptionValue->getValue(),
                    ]
                );

                $attributeOptionValue->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function __invoke(AttributeOptionValueInterface $attributeOptionValue)
    {
        $this->persist($attributeOptionValue);
    }
}
