<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Deleter\V2_0ce\Doctrine;

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine\ProductAttributeQueryBuilder;
use unit\Kiboko\Component\MagentoORM\Deleter\Doctrine\AbstractCatalogAttributeDeleter;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;

class CatalogAttributeDeleterTest extends AbstractCatalogAttributeDeleter
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

    /**
     * @return ProductAttributeQueryBuilderInterface
     */
    protected function getQueryBuilder()
    {
        return new ProductAttributeQueryBuilder(
            $this->getDoctrineConnection(),
            ProductAttributeQueryBuilder::getDefaultTable(),
            ProductAttributeQueryBuilder::getDefaultExtraTable(),
            ProductAttributeQueryBuilder::getDefaultEntityTable(),
            ProductAttributeQueryBuilder::getDefaultVariantTable(),
            ProductAttributeQueryBuilder::getDefaultFamilyTable(),
            ProductAttributeQueryBuilder::getDefaultExtraFields(),
            ProductAttributeQueryBuilder::getDefaultFields()
        );
    }

    public function testRemoveNone()
    {
        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-none',
                'catalog_eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(122);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'catalog_eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([122]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'catalog_eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }
}
