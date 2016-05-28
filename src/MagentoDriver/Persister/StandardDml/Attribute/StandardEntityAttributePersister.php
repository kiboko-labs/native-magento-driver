<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\EntityAttributeInterface;
use Kiboko\Component\MagentoDriver\Persister\EntityAttributePersisterInterface;

class StandardEntityAttributePersister implements EntityAttributePersisterInterface
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
     * @param EntityAttributeInterface $entityAttribute
     */
    public function persist(EntityAttributeInterface $entityAttribute)
    {
        $this->dataQueue->push($entityAttribute);
    }

    public function flush()
    {
        /** @var EntityAttributeInterface $entityAttribute */
        foreach ($this->dataQueue as $entityAttribute) {
            $count = 0;
            if ($entityAttribute->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'entity_type_id' => $entityAttribute->getTypeId(),
                        'attribute_set_id' => $entityAttribute->getAttributeSetId(),
                        'attribute_group_id' => $entityAttribute->getAttributeGroupId(),
                        'attribute_id' => $entityAttribute->getAttributeId(),
                        'sort_order' => $entityAttribute->getSortOrder(),
                    ],
                    [
                        'entity_attribute_id' => $entityAttribute->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'entity_attribute_id' => $entityAttribute->getId(),
                        'entity_type_id' => $entityAttribute->getTypeId(),
                        'attribute_set_id' => $entityAttribute->getAttributeSetId(),
                        'attribute_group_id' => $entityAttribute->getAttributeGroupId(),
                        'attribute_id' => $entityAttribute->getAttributeId(),
                        'sort_order' => $entityAttribute->getSortOrder(),
                    ]
                );

                $entityAttribute->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param EntityAttributeInterface $entityAttribute
     */
    public function __invoke(EntityAttributeInterface $entityAttribute)
    {
        $this->persist($entityAttribute);
    }
}
