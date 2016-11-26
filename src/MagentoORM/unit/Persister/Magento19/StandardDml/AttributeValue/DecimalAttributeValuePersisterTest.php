<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Persister\Magento19\StandardDml\AttributeValue;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\Immutable\ImmutableDecimalAttributeValue;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\Magento19\AttributeValue\DecimalAttributeValuePersister;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class DecimalAttributeValuePersisterTest extends \PHPUnit_Framework_TestCase
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
        $dataset = $this->fixturesLoader->initialDataSet(
            'catalog_product_entity_decimal',
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
            $platform->getTruncateTableSQL(StoreTableSchemaBuilder::getTableName($this->getVersion()))
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
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureCatalogProductEntityTable();
        $schemaBuilder->ensureCatalogProductAttributeValueTable('decimal', 'decimal',
            [
                'precision' => 12,
                'scale' => 4
            ]
        );

        $schemaBuilder->ensureCatalogProductAttributeValueToEntityTypeLinks('decimal');
        $schemaBuilder->ensureCatalogProductAttributeValueToAttributeLinks('decimal');
        $schemaBuilder->ensureCatalogProductAttributeValueToStoreLinks('decimal');
        $schemaBuilder->ensureCatalogProductAttributeValueToCatalogProductEntityLinks('decimal');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables('decimal');

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $this->getVersion(),
            $this->getEdition()
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateStoreTable(
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateCatalogProductEntityTable(
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateCatalogProductAttributeValueTable(
            'decimal',
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new DecimalAttributeValuePersister(
            $this->getDoctrineConnection(),
            ProductAttributeValueQueryBuilder::getDefaultTable('decimal')
        );
    }

    protected function tearDown()
    {
        $this->truncateTables('decimal');
        parent::tearDown();

        $this->persister = null;
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
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

        $expected = $this->fixturesLoader->namedDataSet(
            'do-nothing',
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_product_entity_decimal');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();

        $decimalAttribute = new ImmutableDecimalAttributeValue(
            $this->getAttributeMock(79, 4),
            22.17,
            $this->getProductMock(961),
            1
        );

        $this->persister->persist($decimalAttribute);
        foreach ($this->persister->flush() as $item);

        $expected = $this->fixturesLoader->namedDataSet(
            'insert-one',
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_product_entity_decimal');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();

        $decimalAttribute = ImmutableDecimalAttributeValue::buildNewWith(
            4,
            $this->getAttributeMock(79, 4),
            99.17,
            $this->getProductMock(961),
            0
        );

        $this->persister->persist($decimalAttribute);
        foreach ($this->persister->flush() as $item);

        $expected = $this->fixturesLoader->namedDataSet(
            'update-one',
            'catalog_product_entity_decimal',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_product_entity_decimal');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
