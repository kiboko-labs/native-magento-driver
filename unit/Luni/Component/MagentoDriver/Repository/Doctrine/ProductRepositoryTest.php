<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use DateTimeInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Factory\StandardProductFactory;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductRepository;
use Kiboko\Component\MagentoDriver\Repository\ProductRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class ProductRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

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
                $platform->getTruncateTableSQL('catalog_product_entity')
        );

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();
        $magentoVersion = '1.9';
        $magentoEdition = 'ce';

        $currentSchema = $this->getDoctrineConnection()
                ->getSchemaManager()
                ->createSchema()
        ;

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureCatalogProductEntityTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();
        $schemaBuilder->hydrateCatalogProductEntityTable($magentoVersion, $magentoEdition);

        $this->repository = new ProductRepository(
                $this->getDoctrineConnection(),
                new ProductQueryBuilder(
                    $this->getDoctrineConnection(),
                    ProductQueryBuilder::getDefaultTable(),
                    ProductQueryBuilder::getDefaultFamilyTable(),
                    ProductQueryBuilder::getDefaultCategoryProductTable(),
                    ProductQueryBuilder::getDefaultFields()
                ),
                new StandardProductFactory()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneSimpleById()
    {
        $product = $this->repository->findOneById(3);

        $this->assertInstanceOf(ProductInterface::class, $product);

        $this->assertEquals($product->getId(), 3);
        $this->assertEquals($product->getType(), 'simple');
        $this->assertEquals($product->isConfigurable(), false);
        $this->assertEquals($product->getIdentifier(), 'SIMPLE');
        $this->assertEquals($product->getFamilyId(), 20);
        $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
        $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
        $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
    }

    public function testFetchingOneconfigurableById()
    {
        $product = $this->repository->findOneById(961);

        $this->assertInstanceOf(ProductInterface::class, $product);

        $this->assertEquals($product->getId(), 961);
        $this->assertEquals($product->getType(), 'configurable');
        $this->assertEquals($product->isConfigurable(), true);
        $this->assertEquals($product->getIdentifier(), 'CONFIGURABLE');
        $this->assertEquals($product->getFamilyId(), 17);
        $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
        $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
        $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneSimpleByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier('SIMPLE');

        $this->assertInstanceOf(ProductInterface::class, $product);

        $this->assertEquals($product->getIdentifier(), 'SIMPLE');
        $this->assertEquals($product->getType(), 'simple');
        $this->assertEquals($product->getId(), 3);
        $this->assertEquals($product->isConfigurable(), false);
        $this->assertEquals($product->getFamilyId(), 20);
        $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
        $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
        $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
    }

    public function testFetchingOneConfigurableByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier('CONFIGURABLE');

        $this->assertInstanceOf(ProductInterface::class, $product);

        $this->assertEquals($product->getIdentifier(), 'CONFIGURABLE');
        $this->assertEquals($product->getType(), 'configurable');
        $this->assertEquals($product->getId(), 961);
        $this->assertEquals($product->isConfigurable(), true);
        $this->assertEquals($product->getFamilyId(), 17);
        $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
        $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
        $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
    }

    public function testFetchingOneByIdentifierButNonExistent()
    {
        $this->assertNull($this->repository->findOneByIdentifier('UNKNOWN'));
    }

    public function testFetchingAllByIdentifier()
    {
        $products = $this->repository->findAllByIdentifier(['SIMPLE', 'CONFIGURABLE']);
        foreach ($products as $product) {
            $this->assertInstanceOf(ProductInterface::class, $product);

            $this->assertTrue($product->getIdentifier() === 'CONFIGURABLE' || $product->getIdentifier() === 'SIMPLE');
            $this->assertTrue($product->getType() === 'configurable' || $product->getType() === 'simple');
            $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
            $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
            $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
        }
    }

    public function testFetchingAllById()
    {
        $ids = [3, 961];
        $products = $this->repository->findAllById($ids);
        foreach ($products as $product) {
            $this->assertContains($product->getId(), $ids);
            $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
            $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
            $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
        }
    }

    public function testFetchingAll()
    {
        $products = $this->repository->findAll();
        foreach ($products as $product) {
            $this->assertInstanceOf(ProductInterface::class, $product);

            $this->assertTrue(ctype_digit($product->getId()));
            $this->assertTrue($product->getId() > 0);
            $this->assertTrue(is_string($product->getType()));
            $this->assertTrue(is_bool($product->isConfigurable()));
            $this->assertTrue(is_string($product->getIdentifier()));
            $this->assertTrue(ctype_digit($product->getFamilyId()));
            $this->assertTrue($product->getFamilyId() > 0);

            $this->assertInstanceOf(DateTimeInterface::class, $product->getCreationDate());
            $this->assertInstanceOf(DateTimeInterface::class, $product->getModificationDate());
            $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
        }
    }
}
