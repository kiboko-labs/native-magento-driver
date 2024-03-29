<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDML\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Model\EntityAttributeInterface;
use Kiboko\Component\MagentoORM\Persister\EntityAttributePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDML\InsertUpdateAwareTrait;

class StandardEntityAttributePersister implements EntityAttributePersisterInterface
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
     * @param EntityAttributeInterface $entityAttribute
     */
    public function persist(EntityAttributeInterface $entityAttribute)
    {
        $this->dataQueue->push($entityAttribute);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        /** @var EntityAttributeInterface $entityAttribute */
        foreach ($this->dataQueue as $entityAttribute) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'entity_attribute_id' => $entityAttribute->getId(),
                    'entity_type_id' => $entityAttribute->getTypeId(),
                    'attribute_set_id' => $entityAttribute->getAttributeSetId(),
                    'attribute_group_id' => $entityAttribute->getAttributeGroupId(),
                    'attribute_id' => $entityAttribute->getAttributeId(),
                    'sort_order' => $entityAttribute->getSortOrder(),
                ],
                [
                    'entity_type_id',
                    'attribute_set_id',
                    'attribute_group_id',
                    'attribute_id',
                    'sort_order',
                ],
                'entity_attribute_id'
            );

            if ($entityAttribute->getId() === null) {
                $entityAttribute->persistedToId($this->connection->lastInsertId());
                yield $entityAttribute;
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
