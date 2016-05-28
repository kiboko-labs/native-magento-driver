<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionPersisterInterface;

class AttributeOptionPersister implements AttributeOptionPersisterInterface
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
     * @param AttributeOptionInterface $attributeOption
     */
    public function persist(AttributeOptionInterface $attributeOption)
    {
        $this->dataQueue->push($attributeOption);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $attributeOption) {
            $count = 0;
            if ($attributeOption->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'attribute_id' => $attributeOption->getAttributeId(),
                        'sort_order' => $attributeOption->getSortOrder(),
                    ],
                    [
                        'option_id' => $attributeOption->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'option_id' => $attributeOption->getId(),
                        'attribute_id' => $attributeOption->getAttributeId(),
                        'sort_order' => $attributeOption->getSortOrder(),
                    ]
                );

                $attributeOption->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param AttributeOptionInterface $attributeOption
     */
    public function __invoke(AttributeOptionInterface $attributeOption)
    {
        $this->persist($attributeOption);
    }
}
