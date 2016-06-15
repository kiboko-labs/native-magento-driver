<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Common\Collections\ArrayCollection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\CatalogAttributeRepository;
use Kiboko\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProduct;
use Kiboko\Component\MagentoDriver\Model\Family;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class CatalogAttributeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeRepositoryInterface
     */
    private $repository;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                $this->getFixturesPathname('catalog_eav_attribute', '1.9', 'ce'));

        return $dataset;
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
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $magentoVersion = '1.9';
        $magentoEdition = 'ce';

        $schemaBuilder->hydrateEntityTypeTable($magentoVersion, $magentoEdition);
        $schemaBuilder->hydrateAttributeTable($magentoVersion, $magentoEdition);
        $schemaBuilder->hydrateCatalogAttributeExtensionsTable($magentoVersion, $magentoEdition);

        $this->repository = new CatalogAttributeRepository(
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
        $attributes = $this->repository->findAllByCode('catalog_product', [
            'release_date', 'gift_message_available', ]);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            if ($attribute->getCode() === 'release_date') {
                $this->assertEquals(167, $attribute->getId());
            }
            if ($attribute->getCode() === 'gift_message_available') {
                $this->assertEquals(122, $attribute->getId());
            }
        }
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

        $this->assertInstanceOf(ArrayCollection::class, $attributes);

        $this->assertEquals(0, $attributes->count());
    }

    public function testFetchingAllById()
    {
        $attributes = $this->repository->findAllById([167, 122]);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);

            if ($attribute->getId() === 167) {
                $this->assertEquals('release_date',$attribute->getCode());
            }
            if ($attribute->getId() === 167) {
                $this->assertEquals('gift_message_available', $attribute->getCode());
            }
        }
    }

    public function testFetchingAllByIdButNonExistent()
    {
        $attributes = $this->repository->findAllById([1337, 8695]);

        $this->assertInstanceOf(\Doctrine\Common\Collections\ArrayCollection::class, $attributes);

        $this->assertEquals(0, $attributes->count());
    }

    public function testFetchingAll()
    {
        $attributes = $this->repository->findAll();

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }
        $this->assertEquals(8, $attributes->count());

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('catalog_eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testFetchingAllSimpleProductByEntity()
    {
        $simpleProduct = new SimpleProduct(
            'SIMPLE_PRODUCT',
            Family::buildNewWith(4, 'Default', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $simples = $this->repository->findAllByEntity($simpleProduct);

        /** @todo $simples is null ? */
        foreach ($simples as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }
    }

    public function testFetchingAllConfigurableProductByEntity()
    {
        $configurableProduct = new ConfigurableProduct(
            'CONFIGURABLE_PRODUCT',
            Family::buildNewWith(8, 'Clothing', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $configurables = $this->repository->findAllByEntity($configurableProduct);

        /** @todo $configurables is null ? */
        foreach ($configurables as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
        }
    }

    public function testFetchingAllSimpleProductByEntityButNonExistent()
    {
        $simpleProduct = new SimpleProduct(
            'SIMPLE_PRODUCT',
            Family::buildNewWith(8695, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $simples = $this->repository->findAllByEntity($simpleProduct);

        $this->assertCount(0, $simples);
    }

    public function testFetchingAllConfigurableProductByEntityButNonExistent()
    {
        $configurableProduct = new ConfigurableProduct(
            'CONFIGURABLE_PRODUCT',
            Family::buildNewWith(1331, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $configurables = $this->repository->findAllByEntity($configurableProduct);

        $this->assertCount(0, $configurables);
    }

    public function testFetchingAllByEntityTypeCode()
    {
        $attributes = $this->repository->findAllByEntityTypeCode('catalog_product');

        $this->assertCount(8, $attributes);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            /* @todo: $attribute->getEntityTypeId() is null ? */
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }
    }

    public function testFetchingAllByEntityTypeCodeButNonExistent()
    {
        $attributes = $this->repository->findAllByEntityTypeCode('non_existent');

        /* @todo: return 8 ? */
        $this->assertCount(0, $attributes);
    }

    public function testFetchingAllByEntityTypeId()
    {
        $attributes = $this->repository->findAllByEntityTypeId(4);

        $this->assertCount(8, $attributes);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            /* @todo $attribute->getEntityTypeId() is null ? */
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }
    }

    public function testFetchingAllByEntityTypeIdButNonExistent()
    {
        $attributes = $this->repository->findAllByEntityTypeId(1337);

        $this->assertCount(0, $attributes);
    }

    /**
     * @todo: SQL Error: Table catalog_product_super_attribute not found
     */
    public function testFetchingAllVariantAxisByEntity()
    {
        //        $product = new ConfigurableProduct(
//            'CONFIGURABLE_PRODUCT',
//            Family::buildNewWith(4, 'Default', 1),
//            new \DateTime('now'),
//            new \DateTime('now')
//        );
//
//        $attributes = $this->repository->findAllVariantAxisByEntity($product);
//
//        $this->assertCount(8, $attributes);
//
//        foreach ($attributes as $attribute){
//            $this->assertInstanceOf(AttributeInterface::class, $attribute);
//            $this->assertEquals(4, $attribute->getEntityTypeId());
//        }
    }

    public function testFetchingAllVariantAxisByEntityButNonExistent()
    {
        $product = new SimpleProduct(
            'SIMPLE_PRODUCT',
            Family::buildNewWith(8695, 'non_existent', 1),
            new \DateTime('now'),
            new \DateTime('now')
        );

        $attributes = $this->repository->findAllVariantAxisByEntity($product);

        $this->assertCount(0, $attributes);
    }

    public function testFetchingAllByFamily()
    {
        $attributes = $this->repository->findAllByFamily(Family::buildNewWith(4, 'Default', 1));

        /* @todo: return 0 ? */
        $this->assertCount(8, $attributes);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }
    }
    public function testFetchingAllByFamilyButNonExistent()
    {
        $attributes = $this->repository->findAllByFamily(Family::buildNewWith(8695, 'non_existent', 1));

        $this->assertCount(0, $attributes);
    }

    public function testFetchingAllMandatoryByFamily()
    {
        $attributes = $this->repository->findAllMandatoryByFamily(Family::buildNewWith(4, 'Default', 1));

        /* @todo: return 0 ? */
        $this->assertCount(8, $attributes);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(AttributeInterface::class, $attribute);
            $this->assertEquals(4, $attribute->getEntityTypeId());
        }
    }

    public function testFetchingAllMandatoryByFamilyButNonExistent()
    {
        $attributes = $this->repository->findAllMandatoryByFamily(Family::buildNewWith(8695, 'non_existent', 1));

        $this->assertCount(0, $attributes);
    }
}
