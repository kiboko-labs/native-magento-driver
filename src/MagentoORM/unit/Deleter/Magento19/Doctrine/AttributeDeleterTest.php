<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Deleter\Magento19\Doctrine;

use unit\Kiboko\Component\MagentoORM\Deleter\Doctrine\AbstractAttributeDeleter;

class AttributeDeleterTest extends AbstractAttributeDeleter
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
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(79);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([79]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveOneByCode()
    {
        $this->deleter->deleteOneByCode('cost');

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllByCode()
    {
        $this->deleter->deleteAllByCode(['cost']);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
