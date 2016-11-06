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
        $dataset = $this->fixturesLoader->initialDataSet(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        return $dataset;
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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
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
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateStoreTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateCatalogProductEntityTable(
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateCatalogProductAttributeValueTable(
            'datetime',
            'catalog_product_entity_datetime',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
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
    private function getAttributeMock($attributeId, $entityTypeId = null)
    {
        $mock = $this->createMock(AttributeInterface::class);

        $mock->method('getId')->willReturn($attributeId);
        $mock->method('getEntityTypeId')->willReturn($entityTypeId);

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
        foreach ($this->persister->flush() as $item);
        
        $expected = $this->getDataSet();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable(TableStore::getTableName($GLOBALS['MAGENTO_VERSION']));
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute');
        $actual->addTable('catalog_product_entity');
        $actual->addTable('catalog_product_entity_datetime');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        
        $datetimeAttribute = array(
            'ce' => array(
                '1.9' => new ImmutableDatetimeAttributeValue(
                            $this->getAttributeMock(167, 4),
                            new \DateTime('2016-07-13 12:34:56'),
                            $this->getProductMock(961),
                            1
                    ),
                '2.0' => new ImmutableDatetimeAttributeValue(
                            $this->getAttributeMock(167),
                            new \DateTime('2016-07-13 12:34:56'),
                            $this->getProductMock(961),
                            1
                    ),
            ),
        );
        
        $this->persister->persist($value = $datetimeAttribute[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);
        foreach ($this->persister->flush() as $item);

        $this->assertEquals(24, $value->getId());
        
        $newCatalogProductEntityDatetime = array(
            'ce' => array(
                '1.9' => array(
                    'value_id' => 24,
                    'entity_type_id' => 4,
                    'attribute_id' => 167,
                    'store_id' => 1,
                    'entity_id' => 961,
                    'value' => '2016-07-13 12:34:56',
                ),
                '2.0' => array(
                    'value_id' => 24,
                    'attribute_id' => 167,
                    'store_id' => 1,
                    'entity_id' => 961,
                    'value' => '2016-07-13 12:34:56',
                ),
            ),
        );
        
        $expected = $this->getDataSet();
        $expected->getTable('catalog_product_entity_datetime')->addRow($newCatalogProductEntityDatetime[$GLOBALS['MAGENTO_EDITION']][$GLOBALS['MAGENTO_VERSION']]);
        
        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable(TableStore::getTableName($GLOBALS['MAGENTO_VERSION']));
        $actual->addTable('eav_entity_type');
        $actual->addTable('eav_attribute');
        $actual->addTable('catalog_product_entity');
        $actual->addTable('catalog_product_entity_datetime');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
