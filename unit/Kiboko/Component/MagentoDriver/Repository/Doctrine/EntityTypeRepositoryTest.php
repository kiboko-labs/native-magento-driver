<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Factory\StandardEntityTypeFactory;
use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\EntityTypeRepository;
use Kiboko\Component\MagentoDriver\Repository\EntityTypeRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class EntityTypeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityTypeRepositoryInterface
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

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateEntityTypeTable(
            'eav_entity_type',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new EntityTypeRepository(
            $this->getDoctrineConnection(),
            new EntityTypeQueryBuilder(
                $this->getDoctrineConnection(),
                EntityTypeQueryBuilder::getDefaultTable(),
                EntityTypeQueryBuilder::getDefaultFields()
            ),
            new StandardEntityTypeFactory()
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
        $entityType = $this->repository->findOneById(4);
        $this->assertInstanceOf(EntityTypeInterface::class, $entityType);

        $this->assertEquals(4, $entityType->getId());
        $this->assertEquals('catalog_product', $entityType->getCode());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByCode()
    {
        $entityType = $this->repository->findOneByCode('catalog_product');
        $this->assertInstanceOf(EntityTypeInterface::class, $entityType);
        
        $this->assertEquals('catalog_product', $entityType->getCode());
        $this->assertEquals(4, $entityType->getId());
    }

    public function testFetchingOneByCodeButNonExistent()
    {
        $this->assertNull($this->repository->findOneByCode('Non existent'));
    }
}
