<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Magento20\Doctrine;

use unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\AbstractCatalogAttributeDeleter;

class CatalogAttributeDeleter extends AbstractCatalogAttributeDeleter
{
    /**
     * @return string
     */
    protected function getVersion()
    {
        return '2.0';
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
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(122);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([122]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute_set');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
