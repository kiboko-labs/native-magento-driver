<?php

namespace Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;
use Luni\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
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
     * @param AttributeGroupInterface $attributeGroup
     */
    public function persist(AttributeGroupInterface $attributeGroup)
    {
        $this->dataQueue->push($attributeGroup);
    }

    public function flush()
    {
        foreach ($this->dataQueue as $attributeGroup) {
            $count = 0;
            if ($attributeGroup->getId()) {
                $count = $this->connection->update($this->tableName,
                    [
                        'attribute_set_id' => $attributeGroup->getFamilyId(),
                        'attribute_group_name' => $attributeGroup->getLabel(),
                        'sort_order' => $attributeGroup->getSortOrder(),
                        'default_id' => $attributeGroup->getDefaultId(),
                    ],
                    [
                        'attribute_group_id' => $attributeGroup->getId(),
                    ]
                );
            }

            if ($count <= 0) {
                $this->connection->insert($this->tableName,
                    [
                        'attribute_group_id' => $attributeGroup->getId(),
                        'attribute_set_id' => $attributeGroup->getFamilyId(),
                        'attribute_group_name' => $attributeGroup->getLabel(),
                        'sort_order' => $attributeGroup->getSortOrder(),
                        'default_id' => $attributeGroup->getDefaultId(),
                    ]
                );

                $attributeGroup->persistedToId($this->connection->lastInsertId());
            }
        }
    }

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function __invoke(AttributeGroupInterface $attributeGroup)
    {
        $this->persist($attributeGroup);
    }
}
