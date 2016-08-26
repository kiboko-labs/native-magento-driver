<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
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
     * @param AttributeGroupInterface $attributeGroup
     */
    public function persist(AttributeGroupInterface $attributeGroup)
    {
        $this->dataQueue->push($attributeGroup);
    }

    /**
     * @return \Traversable
     */
    public function flush()
    {
        foreach ($this->dataQueue as $attributeGroup) {
            $this->insertOnDuplicateUpdate($this->connection, $this->tableName,
                [
                    'attribute_group_id' => $attributeGroup->getId(),
                    'attribute_set_id' => $attributeGroup->getFamilyId(),
                    'attribute_group_name' => $attributeGroup->getLabel(),
                    'sort_order' => $attributeGroup->getSortOrder(),
                    'default_id' => $attributeGroup->getDefaultId(),
                    'attribute_group_code' => $attributeGroup->getAttributeGroupCode(),
                    'tab_group_code' => $attributeGroup->getTabGroupCode(),
                ],
                [
                    'attribute_set_id',
                    'attribute_group_name',
                    'sort_order',
                    'default_id',
                    'attribute_group_code',
                    'tab_group_code',
                ]
            );

            if ($attributeGroup->getId() === null) {
                $attributeGroup->persistedToId($this->connection->lastInsertId());
                yield $attributeGroup;
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
