<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeOptionValuePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\InsertUpdateAwareTrait;

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

    /**
     * @return \Traversable
     */
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
                ],
                'value_id'
            );

            if ($attributeOptionValue->getId() === null) {
                $attributeOptionValue->persistedToId($this->connection->lastInsertId());
                yield $attributeOptionValue;
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
