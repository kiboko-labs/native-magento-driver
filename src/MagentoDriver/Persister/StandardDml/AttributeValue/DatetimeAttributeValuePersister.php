<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\AttributeValue;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\DatetimeAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoDriver\Exception\InvalidAttributePersisterTypeException;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;

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
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        if (!$value instanceof DatetimeAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type for "%s", expected "%s", got "%s".',
                $value->getAttributeCode(),
                DatetimeAttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        $this->dataQueue->push($value);
    }

    public function flush()
    {
        /** @var DatetimeAttributeValueInterface $value */
        foreach ($this->dataQueue as $value) {
            $this->insertOnDuplicateUpdate(
                    $this->connection, 
                    $this->tableName,
                    array_filter([
                        'entity_type_id' => $value->getEntityTypeId(),
                        'attribute_id' => $value->getAttributeId(),
                        'store_id' => $value->getStoreId(),
                        'entity_id' => $value->getProductId(),
                        'value' => $value->getValue()->format('Y-m-d H:i:s'),
                    ]),
                    ProductAttributeValueQueryBuilder::getDefaultFields()
                    );
            $value->persistedToId($this->connection->lastInsertId());
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
