<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\AttributeValue;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableDatetimeAttributeValue;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\AttributeValue\DatetimeAttributeValuePersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table\Store as TableStore;

class DatetimeAttributeValuePersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeValuePersisterInterface
     */
    private $persister;

    /**
     * @var LoaderInterface
     */
    private $fixturesLoader;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
    }

    private function truncateTables($backendType)
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL(TableStore::getTableName($GLOBALS['MAGENTO_VERSION']))
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL(sprintf('catalog_product_entity_%s', $backendType))
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

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureCatalogProductEntityTable();
        $schemaBuilder->ensureCatalogProductAttributeValueTable('datetime', 'datetime');

        $schemaBuilder->ensureCatalogProductAttributeValueToEntityTypeLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToAttributeLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToStoreLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToCatalogProductEntityLinks('datetime');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables('datetime');

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateStoreTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateCatalogProductEntityTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateCatalogProductAttributeValueTable(
            'datetime',
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new DatetimeAttributeValuePersister(
            $this->getDoctrineConnection(),
            ProductAttributeValueQueryBuilder::getDefaultTable('datetime')
        );
    }

    protected function tearDown()
    {
        $this->truncateTables('datetime');
        parent::tearDown();

        $this->persister = null;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeInterface
     */
    private function getAttributeMock($attributeId)
    {
        $mock = $this->createMock(AttributeInterface::class);

        $mock->method('getId')->willReturn($attributeId);

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ProductInterface
     */
    private function getProductMock($productId)
    {
        $mock = $this->createMock(ProductInterface::class);

        $mock->method('getId')->willReturn($productId);

        return $mock;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'catalog_product_entity_datetime' => [
                [
                    'value_id' => 20,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 0,
                    'entity_id' => 3,
                    'value' => null,
                ],
                [
                    'value_id' => 23,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 0,
                    'entity_id' => 961,
                    'value' => '2016-12-01 12:34:56',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_product_entity_datetime');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist($value = new ImmutableDatetimeAttributeValue(
            $this->getAttributeMock(167),
            new \DateTime('2016-07-13 12:34:56'),
            $this->getProductMock(961),
            1
        ));
        $this->persister->flush();

        $this->assertEquals(24, $value->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'catalog_product_entity_datetime' => [
                [
                    'value_id' => 20,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 0,
                    'entity_id' => 3,
                    'value' => null,
                ],
                [
                    'value_id' => 23,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 0,
                    'entity_id' => 961,
                    'value' => '2016-12-01 12:34:56',
                ],
                [
                    'value_id' => 24,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 1,
                    'entity_id' => 961,
                    'value' => '2016-07-13 12:34:56',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_product_entity_datetime');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
