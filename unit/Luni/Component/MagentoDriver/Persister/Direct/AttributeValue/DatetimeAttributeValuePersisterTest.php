<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\AttributeValue;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\AttributeValue\DatetimeAttributeValuePersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;

class DatetimeAttributeValuePersisterTest
    extends \PHPUnit_Framework_TestCase
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

    private function truncateTables($backendType)
    {
        $platform = $this->getConnection()->getDatabasePlatform();

        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('core_store')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL(sprintf('catalog_product_entity_%s', $backendType))
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->initConnection();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->connection, $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureCatalogProductEntityTable();
        $schemaBuilder->ensureCatalogProductAttributeValueTable('datetime', 'datetime', []);

        $schemaBuilder->ensureCatalogProductAttributeValueToEntityTypeLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToAttributeLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToStoreLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToCatalogProductEntityLinks('datetime');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables('datetime');
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateStoreTable('1.9', 'ce');
        $schemaBuilder->hydrateCatalogProductEntityTable('1.9', 'ce');

        $this->persister = new DatetimeAttributeValuePersister(
            $this->getConnection(),
            ProductAttributeValueQueryBuilder::getDefaultTable('datetime')
        );
    }

    protected function tearDown()
    {
        $this->truncateTables('datetime');
        $this->closeConnection();
        parent::tearDown();

        $this->persister = null;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeInterface
     */
    private function getAttributeMock($attributeId)
    {
        $mock = $this->getMock(AttributeInterface::class);

        $mock->method('getId')->willReturn($attributeId);

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ProductInterface
     */
    private function getProductMock($productId)
    {
        $mock = $this->getMock(ProductInterface::class);

        $mock->method('getId')->willReturn($productId);

        return $mock;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();
    }

    public function testInsertOne()
    {
        $value = new ImmutableDatetimeAttributeValue(
            $this->getAttributeMock(1),
            new \DateTime('2016-07-13 12:34:56'),
            $this->getProductMock(1)
        );

        $this->persister->initialize();
        $this->persister->persist($value);
        $this->persister->flush();
    }
}
