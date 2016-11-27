<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Deleter\Magento19\Doctrine;

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeQueryBuilder;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeQueryBuilderInterface;
use unit\Kiboko\Component\MagentoORM\Deleter\Doctrine\AbstractAttributeDeleter;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;

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

    /**
     * @return AttributeQueryBuilderInterface
     */
    protected function getQueryBuilder()
    {
        return new AttributeQueryBuilder(
            $this->getDoctrineConnection(),
            AttributeQueryBuilder::getDefaultTable(),
            AttributeQueryBuilder::getDefaultEntityTable(),
            AttributeQueryBuilder::getDefaultFields()
        );
    }

    public function testRemoveNone()
    {
        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-none',
                'eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(122);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([122]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveOneByCode()
    {
        $this->deleter->deleteOneByCode('gift_message_available');

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }

    public function testRemoveAllByCode()
    {
        $this->deleter->deleteAllByCode(['gift_message_available']);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual(
            $this->getFixturesLoader()->namedDataSet(
                'delete-one',
                'eav_attribute',
                DoctrineSchemaBuilder::CONTEXT_DELETER
            ),
            $actual
        );
    }
}
