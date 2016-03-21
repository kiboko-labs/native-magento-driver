<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class ProductAttributeRepositoryTest
    extends \PHPUnit_Framework_TestCase
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
     * @throws \Doctrine\DBAL\DBALException
     */
    private function truncateTables()
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
            $platform->getTruncateTableSQL('catalog_eav_attribute')
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();

        $this->initConnection();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->connection, $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->ensureCatalogAttributeExtensionsToAttributeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateCatalogAttributeExtensionsTable('1.9', 'ce');

        $this->repository = new ProductAttributeRepository(
            $this->getConnection(),
            new ProductAttributeQueryBuilder(
                $this->getConnection(),
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
        $this->closeConnection();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneById()
    {
        $attribute = $this->repository->findOneById(122);
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals($attribute->getId(), 122);
        $this->assertEquals($attribute->getCode(), 'gift_message_available');
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
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