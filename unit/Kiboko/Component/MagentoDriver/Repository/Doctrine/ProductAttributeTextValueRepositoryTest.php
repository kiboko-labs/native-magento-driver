<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\TextAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableTextAttributeValue;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table\Store as TableStore;

class ProductAttributeTextValueRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var ProductAttributeValueRepositoryInterface
     */
    private $repository;

    /**
     * @var AttributeRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $attributeRepositoryMock;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL(TableStore::getTableName($GLOBALS['MAGENTO_VERSION']))
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity_text')
        );
        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();

        $currentSchema = $this->getDoctrineConnection()
            ->getSchemaManager()
            ->createSchema()
        ;

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogProductEntityTable();
        $schemaBuilder->ensureCatalogProductAttributeValueTable('text', 'text');
        $schemaBuilder->ensureCatalogProductAttributeValueToStoreLinks('text');
        $schemaBuilder->ensureCatalogProductAttributeValueToAttributeLinks('text');
        $schemaBuilder->ensureCatalogProductAttributeValueToCatalogProductEntityLinks('text');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateStoreTable(
            'catalog_product_entity_text',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_product_entity_text',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateCatalogProductEntityTable(
            'catalog_product_entity_text',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateCatalogProductAttributeValueTable(
            'text',
            'catalog_product_entity_text',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new ProductAttributeValueRepository(
            $this->getDoctrineConnection(),
            new ProductAttributeValueQueryBuilder(
                $this->getDoctrineConnection(),
                ProductAttributeValueQueryBuilder::getDefaultTable('text'),
                ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable(),
                ProductAttributeValueQueryBuilder::getDefaultFields()
            ),
            $this->getAttributeRepositoryMock(),
            $this->getAttributeValueFactoryMock()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }

    /**
     * @param int    $id
     * @param string $code
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeRepositoryInterface
     */
    private function getAttributeMock($id, $code)
    {
        $mock = $this->createMock(AttributeInterface::class);

        $mock->method('getId')
            ->willReturn($id)
        ;

        $mock->method('getCode')
            ->willReturn($code)
        ;

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeRepositoryInterface
     */
    private function getAttributeRepositoryMock()
    {
        $this->attributeRepositoryMock = $mock = $this->createMock(AttributeRepositoryInterface::class);

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeValueFactoryInterface
     */
    private function getAttributeValueFactoryMock()
    {
        $mock = $this->createMock(AttributeValueFactoryInterface::class);

        $mock->method('buildNew')
            ->with($this->isInstanceOf(AttributeInterface::class), $this->isType('array'))
            ->willReturnCallback(function ($attribute, $data) {
                return ImmutableTextAttributeValue::buildNewWith(
                    $attribute,
                    $data['value_id'],
                    $data['value'],
                    null,
                    $data['store_id']
                );
            })
        ;

        return $mock;
    }

    public function testFetchingOneByProductAndAttributeFromDefault()
    {
        /** @var ProductInterface $product */
        $product = $this->createMock(ProductInterface::class);
        $product
            ->method('getId')
            ->willReturn(3)
        ;

        /** @var AttributeInterface $attribute */
        $attribute = $this->getAttributeMock(210, 'description');

        $this->attributeRepositoryMock
            ->method('findOneById')
            ->with(210)
            ->willReturn($this->getAttributeMock(210, 'description'))
        ;

        /** @var TextAttributeValueInterface $attributeValue */
        $attributeValue = $this->repository->findOneByProductAndAttributeFromDefault($product, $attribute);
        $this->assertInstanceOf(TextAttributeValueInterface::class, $attributeValue);

        $this->assertInternalType('string', $attributeValue->getValue());
    }

    public function testFetchingOneByProductAndAttributeFromDefaultButNonExistent()
    {
        /** @var ProductInterface $product */
        $product = $this->createMock(ProductInterface::class);
        $product
            ->method('getId')
            ->willReturn(PHP_INT_MAX - 1)
        ;

        /** @var AttributeInterface $attribute */
        $attribute = $this->getAttributeMock(210, 'description');

        $this->assertNull($this->repository->findOneByProductAndAttributeFromDefault($product, $attribute));
    }
}
