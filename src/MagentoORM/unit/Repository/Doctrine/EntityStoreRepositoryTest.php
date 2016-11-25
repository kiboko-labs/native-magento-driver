<?php

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\StandardEntityStoreFactory;
use Kiboko\Component\MagentoORM\Model\EntityStoreInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\EntityStoreRepository;
use Kiboko\Component\MagentoORM\Repository\EntityStoreRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureEntityStoreTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateEntityStoreTable(
            'eav_entity_store',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new EntityStoreRepository(
            $this->getDoctrineConnection(),
            new EntityStoreQueryBuilder(
                $this->getDoctrineConnection(),
                EntityStoreQueryBuilder::getDefaultTable(),
                EntityStoreQueryBuilder::getDefaultFields()
            ),
            new StandardEntityStoreFactory()
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

    public function testFetchingOneById()
    {
        $entityStore = $this->repository->findOneById(6);

        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals(6, $entityStore->getId());
        $this->assertEquals(1, $entityStore->getStoreId());
        $this->assertEquals(4, $entityStore->getTypeId());
        $this->assertEquals(6, $entityStore->getIncrementPrefix());
        $this->assertEquals('600000232', $entityStore->getIncrementLastId());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(1337));
    }

    public function testFetchingOneByStoreId()
    {
        $entityStore = $this->repository->findOneByStoreId(0);
        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals(0, $entityStore->getStoreId());
        $this->assertEquals(1, $entityStore->getTypeId());
        $this->assertEquals(1, $entityStore->getId());
        $this->assertEquals(0, $entityStore->getIncrementPrefix());
        $this->assertEquals('000004372', $entityStore->getIncrementLastId());
    }

    public function testFetchingOneByStoreIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneByStoreId(1337));
    }

    public function testFetchingOneByTypeId()
    {
        $entityStore = $this->repository->findOneByTypeId(4);
        $this->assertInstanceOf(EntityStoreInterface::class, $entityStore);

        $this->assertEquals(0, $entityStore->getStoreId());
        $this->assertEquals(4, $entityStore->getTypeId());
        $this->assertEquals(2, $entityStore->getId());
        $this->assertEquals(5, $entityStore->getIncrementPrefix());
        $this->assertEquals('50000047W', $entityStore->getIncrementLastId());
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
        $this->assertNotEmpty($entityStore);
    }
}
