<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\AttributeValue;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributePersisterTypeException;

class DatetimeAttributeValuePersister
    implements AttributeValuePersisterInterface
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
        $this->dataQueue = new \SplQueue();
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        if (!$value instanceof DatetimeAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type for "%s", expected "%s", got "%s".',
                $value->getAttributeCode(),
                DatetimeAttributeValueInterface::class,
                get_class($value)
            ));
        }

        $this->dataQueue->push($value);
    }

    /**
     * @return void
     */
    public function flush()
    {
        /** @var DatetimeAttributeValueInterface $value */
        foreach ($this->dataQueue as $value) {
            if ($value->getId()) {
                $this->connection->update($this->tableName,
                    [
                        'entity_type_id' => 4,
                        'attribute_id'   => $value->getAttributeId(),
                        'store_id'       => $value->getStoreId(),
                        'entity_id'      => $value->getProductId(),
                        'value'          => $value->getValue()->format('Y-m-d H:i:s'),
                    ],
                    [
                        'value_id'       => $value->getId(),
                    ]
                );
            } else {
                $this->connection->insert($this->tableName,
                    [
                        'entity_type_id' => 4,
                        'attribute_id'   => $value->getAttributeId(),
                        'store_id'       => $value->getStoreId(),
                        'entity_id'      => $value->getProductId(),
                        'value'          => $value->getValue()->format('Y-m-d H:i:s'),
                    ]
                );

                $value->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param AttributeValueInterface $value
     * @return void
     */
    public function __invoke(AttributeValueInterface $value)
    {
        $this->persist($value);
    }
}
