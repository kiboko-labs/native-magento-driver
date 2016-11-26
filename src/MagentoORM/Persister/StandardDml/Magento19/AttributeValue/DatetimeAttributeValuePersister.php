<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Magento19\AttributeValue;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface as BaseAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoORM\Exception\InvalidAttributePersisterTypeException;
use Kiboko\Component\MagentoORM\Persister\StandardDml\InsertUpdateAwareTrait;

class DatetimeAttributeValuePersister implements AttributeValuePersisterInterface
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
     * @param BaseAttributeValueInterface $value
     */
    public function persist(BaseAttributeValueInterface $value)
    {
        if (!$value instanceof AttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type, expected "%s", got "%s".',
                BaseAttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        if (!$value instanceof DatetimeAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type, expected "%s", got "%s".',
                DatetimeAttributeValueInterface::class,
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
        /** @var DatetimeAttributeValueInterface $value */
        foreach ($this->dataQueue as $value) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'value_id' => $value->getId(),
                    'entity_type_id' => $value->getEntityTypeId(),
                    'attribute_id' => $value->getAttributeId(),
                    'store_id' => $value->getStoreId(),
                    'entity_id' => $value->getProductId(),
                    'value' => $value->getValue() ? $value->getValue()->format('Y-m-d H:i:s') : null,
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
     * @param BaseAttributeValueInterface $value
     */
    public function __invoke(BaseAttributeValueInterface $value)
    {
        $this->persist($value);
    }
}
