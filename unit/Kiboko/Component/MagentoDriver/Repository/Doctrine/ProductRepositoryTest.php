<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Broker\ProductFactoryBroker;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Factory\Product\ConfigurableProductFactory;
use Kiboko\Component\MagentoDriver\Factory\Product\SimpleProductFactory;
use Kiboko\Component\MagentoDriver\Factory\StandardProductFactory;
use Kiboko\Component\MagentoDriver\Matcher\Product\ProductTypeMatcher;
use Kiboko\Component\MagentoDriver\Model\Family;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductRepository;
use Kiboko\Component\MagentoDriver\Repository\FamilyRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\RepositoryLoader;

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
        $schemaBuilder->hydrateCatalogProductEntityTable(
            'catalog_product_entity',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        /** @var FamilyRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $familyRepository */
        $familyRepository = $this->createMock(
            FamilyRepositoryInterface::class
        );

        $familyRepository->method('findOneById')
            ->willReturn(new Family('Default'));

        $familyRepository->method('findOneByName')
            ->willReturn(new Family('Default'));

        $productFactoryBroker = new ProductFactoryBroker();
        $productFactoryBroker->addFactory(
            new SimpleProductFactory($familyRepository),
            new ProductTypeMatcher('simple')
        );
        $productFactoryBroker->addFactory(
            new ConfigurableProductFactory($familyRepository),
            new ProductTypeMatcher('configurable')
        );

        $this->repository = new ProductRepository(
            $this->getDoctrineConnection(),
            new ProductQueryBuilder(
                $this->getDoctrineConnection(),
                ProductQueryBuilder::getDefaultTable(),
                ProductQueryBuilder::getDefaultFamilyTable(),
                ProductQueryBuilder::getDefaultCategoryProductTable(),
                ProductQueryBuilder::getDefaultFields()
            ),
            new StandardProductFactory($productFactoryBroker)
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneSimpleByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier(3);

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('simple', $product->getType());
        $this->assertNotNull($product->getId());
    }

    public function testFetchingOneConfigurableByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier(961);

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('configurable', $product->getType());
        $this->assertNotNull($product->getId());
    }

    public function testFetchingOneByIdentifierButNonExistent()
    {
        $this->assertNull($this->repository->findOneByIdentifier(123));
    }

    public function testFetchingOneSimpleByCode()
    {
        $product = $this->repository->findOneByIdentifier('SIMPLE');

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('simple', $product->getType());
        $this->assertNotNull($product->getId());
    }

    public function testFetchingOneConfigurableByCode()
    {
        $product = $this->repository->findOneByIdentifier('CONFIGURABLE');

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('configurable', $product->getType());
        $this->assertNotNull($product->getId());
    }

    public function testFetchingOneByCodeButNonExistent()
    {
        $this->assertNull($this->repository->findOneByIdentifier('UNKNOWN'));
    }

    public function testFetchingAllByCode()
    {
        $products = $this->repository->findAllByIdentifier(['SIMPLE', 'CONFIGURABLE']);

        $count = 0;
        foreach ($products as $product) {
            ++$count;

            $this->assertInstanceOf(ProductInterface::class, $product);
        }

        $this->assertEquals(2, $count);
    }

    public function testFetchingAllByIdentifier()
    {
        $products = $this->repository->findAllByIdentifier([3, 961]);

        $count = 0;
        foreach ($products as $product) {
            ++$count;

            $this->assertInstanceOf(ProductInterface::class, $product);
            $this->assertInstanceOf(\DateTimeInterface::class, $product->getCreationDate());
            $this->assertInstanceOf(\DateTimeInterface::class, $product->getModificationDate());
            $this->assertInstanceOf(FamilyInterface::class, $product->getFamily());
        }

        $this->assertEquals(2, $count);
    }

    public function testFetchingAll()
    {
        $products = $this->repository->findAll();

        $count = 0;
        foreach ($products as $product) {
            ++$count;

            $this->assertInstanceOf(ProductInterface::class, $product);
        }

        $this->assertEquals(2, $count);
    }
}
