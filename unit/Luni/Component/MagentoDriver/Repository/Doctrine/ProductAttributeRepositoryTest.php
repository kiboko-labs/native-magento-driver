<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository;

use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class ProductAttributeRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->ensureCatalogAttributeExtensionsToAttributeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateCatalogAttributeExtensionsTable('1.9', 'ce');

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

        $this->assertEquals($attribute->getId(), 79);
        $this->assertEquals($attribute->getCode(), 'cost');
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(23));
    }

    public function testFetchingOneByCode()
    {
        $attribute = $this->repository->findOneByCode('release_date', 'catalog_product');
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals($attribute->getCode(), 'release_date');
        $this->assertEquals($attribute->getId(), 167);
    }

    public function testFetchingOneByCodeButNonExistent()
    {
        $this->assertNull($this->repository->findOneByCode('non_existent', 'catalog_product'));
    }
}
