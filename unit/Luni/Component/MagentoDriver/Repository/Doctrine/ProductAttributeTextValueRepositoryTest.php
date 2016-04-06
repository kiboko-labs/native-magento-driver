<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableTextAttributeValue;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

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
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet();

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
            $platform->getTruncateTableSQL('core_store')
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

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
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
        $schemaBuilder->hydrateStoreTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateCatalogProductEntityTable('1.9', 'ce');
        $schemaBuilder->hydrateCatalogProductAttributeValueTable('text', '1.9', 'ce');

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
    }

    /**
     * @param int $id
     * @param string $code
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeRepositoryInterface
     */
    private function getAttributeMock($id, $code)
    {
        $mock = $this->getMock(AttributeInterface::class);

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
        $this->attributeRepositoryMock = $mock = $this->getMock(AttributeRepositoryInterface::class);

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeValueFactoryInterface
     */
    private function getAttributeValueFactoryMock()
    {
        $mock = $this->getMock(AttributeValueFactoryInterface::class);

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
        $product = $this->getMock(ProductInterface::class);
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
        $product = $this->getMock(ProductInterface::class);
        $product
            ->method('getId')
            ->willReturn(PHP_INT_MAX - 1)
        ;

        /** @var AttributeInterface $attribute */
        $attribute = $this->getAttributeMock(210, 'description');

        $this->assertNull($this->repository->findOneByProductAndAttributeFromDefault($product, $attribute));
    }
}
