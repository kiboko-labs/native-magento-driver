<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionValuePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

class AttributeOptionValuePersister implements AttributeOptionValuePersisterInterface
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
     * @param AttributeOptionValueInterface $attributeOptionValue
     */
    public function persist(AttributeOptionValueInterface $attributeOptionValue)
    {
        $this->dataQueue->push($attributeOptionValue);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $attributeOptionValue) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'value_id' => $attributeOptionValue->getId(),
                    'option_id' => $attributeOptionValue->getOptionId(),
                    'store_id' => $attributeOptionValue->getStoreId(),
                    'value' => $attributeOptionValue->getValue(),
                ],
                [
                    'option_id',
                    'store_id',
                    'value',
                ]
            );

            $attributeOptionValue->persistedToId($this->connection->lastInsertId());
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
