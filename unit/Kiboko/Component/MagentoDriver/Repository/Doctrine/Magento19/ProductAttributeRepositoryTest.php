<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine\Magento19;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\Magento19\ProductAttributeRepository;
use Kiboko\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProduct;
use Kiboko\Component\MagentoDriver\Model\Family;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class ProductAttributeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $repository;

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
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_super_attribute')
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
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureCatalogProductSuperAttributeTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateEntityTypeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateCatalogAttributeExtensionsTable(
            'catalog_eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new ProductAttributeRepository(
            $this->getDoctrineConnection(),
            new ProductAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                ProductAttributeQueryBuilder::getDefaultTable(),
                ProductAttributeQueryBuilder::getDefaultExtraTable(),
                ProductAttributeQueryBuilder::getDefaultEntityTable(),
                ProductAttributeQueryBuilder::getDefaultVariantTable(),
                ProductAttributeQueryBuilder::getDefaultFamilyTable(),
                ProductAttributeQueryBuilder::getDefaultFields(),
                ProductAttributeQueryBuilder::getDefaultExtraFields()
            )
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneById()
    {
        $attribute = $this->repository->findOneById(79);
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals(79, $attribute->getId());
        $this->assertEquals('cost', $attribute->getCode());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(23));
    }

    public function testFetchingOneByCode()
    {
        $attribute = $this->repository->findOneByCode('release_date', 'catalog_product');
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals('release_date', $attribute->getCode());
        $this->assertEquals(167, $attribute->getId());
    }

    public function testFetchingOneByCodeButNonExistent()
    {
        $this->assertNull($this->repository->findOneByCode('non_existent', 'catalog_product'));
    }

    public function testFetchingAllByCode()
    {
        $attributes = $this->repository->findAllByCode('catalog_product',
            [
                'release_date',
                'gift_message_available'
            ]
        );

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            if ($attribute->getCode() === 'release_date') {
                $this->assertEquals(167, $attribute->getId());
            }
            if ($attribute->getCode() === 'gift_message_available') {
                $this->assertEquals(122, $attribute->getId());
            }
        }

        $this->assertEquals(2, $items);
    }

    public function testFetchingAllByCodeButNonExistent()
    {
        $attributes = $this->repository->findAllByCode(
            'catalog_product',
            [
                'non_existent',
                'non_existent_too',
            ]
        );

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllById()
    {
        $attributes = $this->repository->findAllById([167, 122]);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);

            if ($attribute->getId() === 167) {
                $this->assertEquals('release_date',$attribute->getCode());
            }
            if ($attribute->getId() === 167) {
                $this->assertEquals('gift_message_available', $attribute->getCode());
            }
        }

        $this->assertEquals(2, $items);
    }

    public function testFetchingAllByIdButNonExistent()
    {
        $attributes = $this->repository->findAllById([1337, 8695]);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAll()
    {
        $attributes = $this->repository->findAll();

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }

        $this->assertEquals(8, $items);
    }

    public function testFetchingAllFromSimpleProductByEntity()
    {
        $simpleProduct = new SimpleProduct(
            'SIMPLE_PRODUCT',
            Family::buildNewWith(4, 'Default', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllByEntity($simpleProduct);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllConfigurableProductByEntity()
    {
        $configurableProduct = new ConfigurableProduct(
            'CONFIGURABLE_PRODUCT',
            Family::buildNewWith(8, 'Clothing', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllByEntity($configurableProduct);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllSimpleProductByEntityButNonExistent()
    {
        $simpleProduct = new SimpleProduct(
            'SIMPLE_PRODUCT',
            Family::buildNewWith(8695, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllByEntity($simpleProduct);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllConfigurableProductByEntityButNonExistent()
    {
        $configurableProduct = new ConfigurableProduct(
            'CONFIGURABLE_PRODUCT',
            Family::buildNewWith(1331, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllByEntity($configurableProduct);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }

        $this->assertEquals(0, $items);
    }

    /**
     * @todo: SQL Error: Table catalog_product_super_attribute not found
     */
    public function testFetchingAllVariantAxisByEntity()
    {
        $product = new ConfigurableProduct(
            'CONFIGURABLE_PRODUCT',
            Family::buildNewWith(4, 'Default', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllVariantAxisByEntity($product);

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute){
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllVariantAxisByEntityButNonExistent()
    {
        $product = SimpleProduct::buildNewWith(
            1234,
            'SIMPLE_PRODUCT',
            Family::buildNewWith(8695, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllVariantAxisByEntity($product);

        $this->assertInstanceOf(\Traversable::class, $attributes);
    }

    public function testFetchingAllByFamily()
    {
        $attributes = $this->repository->findAllByFamily(Family::buildNewWith(4, 'Default', 1));

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }

        $this->assertEquals(0, $items);
    }
    public function testFetchingAllByFamilyButNonExistent()
    {
        $attributes = $this->repository->findAllByFamily(Family::buildNewWith(8695, 'non_existent', 1));

        $this->assertInstanceOf(\Traversable::class, $attributes);
    }

    public function testFetchingAllMandatoryByFamily()
    {
        $attributes = $this->repository->findAllMandatoryByFamily(Family::buildNewWith(4, 'Default', 1));

        $this->assertInstanceOf(\Traversable::class, $attributes);

        $items = 0;
        foreach ($attributes as $attribute) {
            ++$items;

            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }

        $this->assertEquals(0, $items);
    }

    public function testFetchingAllMandatoryByFamilyButNonExistent()
    {
        $attributes = $this->repository->findAllMandatoryByFamily(Family::buildNewWith(8695, 'non_existent', 1));

        $this->assertInstanceOf(\Traversable::class, $attributes);
    }
}
