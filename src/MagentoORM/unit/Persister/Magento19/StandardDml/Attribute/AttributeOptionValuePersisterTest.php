<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Persister\Magento19\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Model\AttributeOptionValue;
use Kiboko\Component\MagentoORM\Persister\AttributeOptionValuePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\AttributeOptionValuePersister;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class AttributeOptionValuePersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeOptionValuePersisterInterface
     */
    private $persister;

    /**
     * @var LoaderInterface
     */
    private $fixturesLoader;

    /**
     * @return string
     */
    private function getVersion()
    {
        return '1.9';
    }

    /**
     * @return string
     */
    private function getEdition()
    {
        return 'ce';
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_option')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL(StoreTableSchemaBuilder::getTableName($this->getVersion()))
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_option_value')
        );

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        $currentSchema = $this->getDoctrineConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeOptionTable();
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureAttributeOptionValueTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $this->getVersion(),
            $this->getEdition()
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeOptionTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateStoreTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeOptionValueTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new AttributeOptionValuePersister(
            $this->getDoctrineConnection(),
            AttributeOptionValueQueryBuilder::getDefaultTable()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = null;
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        foreach ($this->persister->flush() as $item);

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_option_value' => [
                [
                    'value_id' => 1,
                    'option_id' => 1,
                    'store_id' => 0,
                    'value' => 'red',
                ],
                [
                    'value_id' => 2,
                    'option_id' => 1,
                    'store_id' => 1,
                    'value' => 'Rouge',
                ],
                [
                    'value_id' => 3,
                    'option_id' => 2,
                    'store_id' => 0,
                    'value' => 'green',
                ],
                [
                    'value_id' => 4,
                    'option_id' => 2,
                    'store_id' => 1,
                    'value' => 'Vert',
                ],
                [
                    'value_id' => 5,
                    'option_id' => 3,
                    'store_id' => 0,
                    'value' => 'blue',
                ],
                [
                    'value_id' => 6,
                    'option_id' => 3,
                    'store_id' => 1,
                    'value' => 'Bleu',
                ],
                [
                    'value_id' => 7,
                    'option_id' => 4,
                    'store_id' => 0,
                    'value' => 'black',
                ],
                [
                    'value_id' => 8,
                    'option_id' => 4,
                    'store_id' => 1,
                    'value' => 'Noir',
                ],
                [
                    'value_id' => 9,
                    'option_id' => 5,
                    'store_id' => 0,
                    'value' => 'white',
                ],
                [
                    'value_id' => 10,
                    'option_id' => 5,
                    'store_id' => 1,
                    'value' => 'Blanc',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist($attributeOptionValue = new AttributeOptionValue(
            1, 2, 'Red'
        ));
        foreach ($this->persister->flush() as $item);

        $this->assertEquals(11, $attributeOptionValue->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_option_value' => [
                [
                    'value_id' => 1,
                    'option_id' => 1,
                    'store_id' => 0,
                    'value' => 'red',
                ],
                [
                    'value_id' => 2,
                    'option_id' => 1,
                    'store_id' => 1,
                    'value' => 'Rouge',
                ],
                [
                    'value_id' => 3,
                    'option_id' => 2,
                    'store_id' => 0,
                    'value' => 'green',
                ],
                [
                    'value_id' => 4,
                    'option_id' => 2,
                    'store_id' => 1,
                    'value' => 'Vert',
                ],
                [
                    'value_id' => 5,
                    'option_id' => 3,
                    'store_id' => 0,
                    'value' => 'blue',
                ],
                [
                    'value_id' => 6,
                    'option_id' => 3,
                    'store_id' => 1,
                    'value' => 'Bleu',
                ],
                [
                    'value_id' => 7,
                    'option_id' => 4,
                    'store_id' => 0,
                    'value' => 'black',
                ],
                [
                    'value_id' => 8,
                    'option_id' => 4,
                    'store_id' => 1,
                    'value' => 'Noir',
                ],
                [
                    'value_id' => 9,
                    'option_id' => 5,
                    'store_id' => 0,
                    'value' => 'white',
                ],
                [
                    'value_id' => 10,
                    'option_id' => 5,
                    'store_id' => 1,
                    'value' => 'Blanc',
                ],
                [
                    'value_id' => 11,
                    'option_id' => 1,
                    'store_id' => 2,
                    'value' => 'Red',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        $this->persister->persist(AttributeOptionValue::buildNewWith(
            1, 1, 0, 'rot'
        ));
        foreach ($this->persister->flush() as $item);

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_option_value' => [
                [
                    'value_id' => 1,
                    'option_id' => 1,
                    'store_id' => 0,
                    'value' => 'rot',
                ],
                [
                    'value_id' => 2,
                    'option_id' => 1,
                    'store_id' => 1,
                    'value' => 'Rouge',
                ],
                [
                    'value_id' => 3,
                    'option_id' => 2,
                    'store_id' => 0,
                    'value' => 'green',
                ],
                [
                    'value_id' => 4,
                    'option_id' => 2,
                    'store_id' => 1,
                    'value' => 'Vert',
                ],
                [
                    'value_id' => 5,
                    'option_id' => 3,
                    'store_id' => 0,
                    'value' => 'blue',
                ],
                [
                    'value_id' => 6,
                    'option_id' => 3,
                    'store_id' => 1,
                    'value' => 'Bleu',
                ],
                [
                    'value_id' => 7,
                    'option_id' => 4,
                    'store_id' => 0,
                    'value' => 'black',
                ],
                [
                    'value_id' => 8,
                    'option_id' => 4,
                    'store_id' => 1,
                    'value' => 'Noir',
                ],
                [
                    'value_id' => 9,
                    'option_id' => 5,
                    'store_id' => 0,
                    'value' => 'white',
                ],
                [
                    'value_id' => 10,
                    'option_id' => 5,
                    'store_id' => 1,
                    'value' => 'Blanc',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option_value');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
