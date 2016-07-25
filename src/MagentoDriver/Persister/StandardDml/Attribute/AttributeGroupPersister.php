<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\InsertUpdateAwareTrait;

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

    public function flush()
    {
        foreach ($this->dataQueue as $attributeGroup) {
            
            $attributeGroupDatas = array(
                'ce' => array(
                    '1.9' => array(
                        'attribute_group_id' => $attributeGroup->getId(),
                        'attribute_set_id' => $attributeGroup->getFamilyId(),
                        'attribute_group_name' => $attributeGroup->getLabel(),
                        'sort_order' => $attributeGroup->getSortOrder(),
                        'default_id' => $attributeGroup->getDefaultId(),
                    ),
                    '2.0' => array(
                        'attribute_group_id' => $attributeGroup->getId(),
                        'attribute_set_id' => $attributeGroup->getFamilyId(),
                        'attribute_group_name' => $attributeGroup->getLabel(),
                        'sort_order' => $attributeGroup->getSortOrder(),
                        'default_id' => $attributeGroup->getDefaultId(),
                        'attribute_group_code' => $attributeGroup->getAttributeGroupCode(),
                        'tab_group_code' => $attributeGroup->getTabGroupCode(),
                    )
                )
            );
            
            $attributeGroupColumns = array(
                'ce' =>array(
                    '1.9' => array(
                        'attribute_set_id',
                        'attribute_group_name',
                        'sort_order',
                        'default_id',
                    ),
                    '2.0' => array(
                        'attribute_set_id',
                        'attribute_group_name',
                        'sort_order',
                        'default_id',
                        'attribute_group_code',
                        'tab_group_code',
                    )
                )
            );
            
            $this->insertOnDuplicateUpdate(
                    $this->connection, 
                    $this->tableName,
                    $attributeGroupDatas[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']],
                    $attributeGroupColumns[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]
            );
            $attributeGroup->persistedToId($this->connection->lastInsertId());
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
