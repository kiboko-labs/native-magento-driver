<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Repository\Magento20\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Broker\ProductFactoryBroker;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Factory\Product\ConfigurableProductFactory;
use Kiboko\Component\MagentoORM\Factory\Product\SimpleProductFactory;
use Kiboko\Component\MagentoORM\Factory\StandardProductFactory;
use Kiboko\Component\MagentoORM\Matcher\Product\ProductTypeMatcher;
use Kiboko\Component\MagentoORM\Model\Family;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\ProductRepository;
use Kiboko\Component\MagentoORM\Repository\FamilyRepositoryInterface;
use Kiboko\Component\MagentoORM\Repository\ProductRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

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
     * @return string
     */
    private function getVersion()
    {
        return '2.0';
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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
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
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
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
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }

    public function testFetchingOneSimpleById()
    {
        $product = $this->repository->findOneById(3);

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('simple', $product->getType());
        $this->assertNotNull($product->getId());
        $this->assertEquals('SIMPLE', $product->getIdentifier());
    }

    public function testFetchingOneConfigurableById()
    {
        $product = $this->repository->findOneById(961);

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('configurable', $product->getType());
        $this->assertNotNull($product->getId());
        $this->assertEquals('CONFIGURABLE', $product->getIdentifier());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneSimpleByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier('SIMPLE');

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('simple', $product->getType());
        $this->assertNotNull($product->getId());
        $this->assertEquals('SIMPLE', $product->getIdentifier());
    }

    public function testFetchingOneConfigurableByIdentifier()
    {
        $product = $this->repository->findOneByIdentifier('CONFIGURABLE');

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('configurable', $product->getType());
        $this->assertNotNull($product->getId());
        $this->assertEquals('CONFIGURABLE', $product->getIdentifier());
    }

    public function testFetchingOneByIdentifierButNonExistent()
    {
        $this->assertNull($this->repository->findOneByIdentifier('UNKNOWN'));
    }

    public function testFetchingAllByIdentifier()
    {
        $products = $this->repository->findAllByIdentifier(['SIMPLE', 'CONFIGURABLE', 'UNKNOWN']);

        $count = 0;
        foreach ($products as $product) {
            ++$count;

            $this->assertInstanceOf(ProductInterface::class, $product);
        }

        $this->assertEquals(2, $count);
    }

    public function testFetchingAllById()
    {
        $products = $this->repository->findAllById([3, 961, 1337]);

        $count = 0;
        foreach ($products as $product) {
            ++$count;

            $this->assertInstanceOf(ProductInterface::class, $product);
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
