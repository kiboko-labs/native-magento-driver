<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Deleter\V1_9ce\Doctrine;

use unit\Kiboko\Component\MagentoORM\Deleter\Doctrine\AbstractEntityAttributeDeleter;

class EntityAttributeDeleterTest extends AbstractEntityAttributeDeleter
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
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);

        $this->assertTableRowCount('eav_entity_attribute', $this->getInitialDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
