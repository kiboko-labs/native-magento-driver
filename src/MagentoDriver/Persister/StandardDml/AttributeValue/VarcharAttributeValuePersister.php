<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\AttributeValue;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\VarcharAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoDriver\Exception\InvalidAttributePersisterTypeException;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

class VarcharAttributeValuePersister implements AttributeValuePersisterInterface
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
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        if (!$value instanceof VarcharAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type for "%s", expected "%s", got "%s".',
                $value->getAttributeCode(),
                VarcharAttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        $this->dataQueue->push($value);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        /** @var VarcharAttributeValueInterface $value */
        foreach ($this->dataQueue as $value) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'value_id' => $value->getId(),
                    'entity_type_id' => $value->getEntityTypeId(),
                    'attribute_id' => $value->getAttributeId(),
                    'store_id' => $value->getStoreId(),
                    'entity_id' => $value->getProductId(),
                    'value' => (string) $value->getValue(),
                ],
                [
                    'entity_type_id',
                    'attribute_id',
                    'store_id',
                    'entity_id',
                    'value',
                ],
                'value_id'
            );

            if ($value->getId() === null) {
                $value->persistedToId($this->connection->lastInsertId());
                yield $value;
            }
        }
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }
}
