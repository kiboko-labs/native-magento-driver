<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Factory\StandardEntityStoreFactory;
use Luni\Component\MagentoDriver\Model\EntityStoreInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use Luni\Component\MagentoDriver\Repository\Doctrine\EntityStoreRepository;
use Luni\Component\MagentoDriver\Repository\EntityStoreRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class EntityStoreRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityStoreRepositoryInterface
     *
     * @todo
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
                $platform->getTruncateTableSQL('eav_entity_store')
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
        $schemaBuilder->ensureEntityStoreTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();
        $schemaBuilder->hydrateEntityStoreTable('1.9', 'ce');

        $this->repository = new EntityStoreRepository(
                $this->getDoctrineConnection(), new EntityStoreQueryBuilder(
                $this->getDoctrineConnection(), EntityStoreQueryBuilder::getDefaultTable(), EntityStoreQueryBuilder::getDefaultFields()
                ), new StandardEntityStoreFactory()
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
        $entityStore = $this->repository->findOneById(6);

        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals($entityStore->getId(), 6);
        $this->assertEquals($entityStore->getStoreId(), '2');
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(1337));
    }

    public function testFetchingOneByStoreId()
    {
        $entityStore = $this->repository->findOneByStoreId(2);
        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals($entityStore->getStoreId(), 2);
        $this->assertEquals($entityStore->getTypeId(), 4);
        $this->assertEquals($entityStore->getId(), 6);
    }

    public function testFetchingOneByStoreIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneByStoreId(1337));
    }

    public function testFetchingOneByTypeId()
    {
        $entityStore = $this->repository->findOneByTypeId(2);
        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals($entityStore->getStoreId(), 1);
        $this->assertEquals($entityStore->getTypeId(), 2);
        $this->assertEquals($entityStore->getId(), 7);
    }

    public function testFetchingOneByTypeIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneByTypeId(1337));
    }

    public function testFetchingAll()
    {
        $entityStore = $this->repository->findAll();
        $this->assertTrue(is_array($entityStore));
        foreach ($entityStore as $singleEntityStore) {
            $this->assertInstanceOf(EntityStoreInterface::class, $singleEntityStore);
        }
        $this->assertGreaterThanOrEqual(1, count($entityStore));
    }
}
