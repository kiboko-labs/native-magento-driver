<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Deleter\Magento19\Doctrine;

use unit\Kiboko\Component\MagentoORM\Deleter\Doctrine\AbstractAttributeOptionValueDeleter;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class AttributeOptionValueDeleterTest extends AbstractAttributeOptionValueDeleter
{
    /**
     * @return string
     */
    protected function getVersion()
    {
        return '1.9';
    }

    /**
     * @return string
     */
    protected function getEdition()
    {
        return 'ce';
    }

    public function testRemoveNone()
    {
        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');
        $actual->addTable(StoreTableSchemaBuilder::getTableName($this->getVersion()));

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');
        $actual->addTable(StoreTableSchemaBuilder::getTableName($this->getVersion()));

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');
        $actual->addTable(StoreTableSchemaBuilder::getTableName($this->getVersion()));

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
