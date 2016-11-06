<?php

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\StandardFamilyFactory;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository;
use Kiboko\Component\MagentoORM\Repository\FamilyRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

class FamilyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var FamilyRepositoryInterface
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
            $platform->getTruncateTableSQL('eav_attribute_set')
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
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureFamilyToEntityTypeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateEntityTypeTable(
            'eav_attribute_set',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateFamilyTable(
            'eav_attribute_set',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new FamilyRepository(
            $this->getDoctrineConnection(),
            new FamilyQueryBuilder(
                $this->getDoctrineConnection(),
                FamilyQueryBuilder::getDefaultTable(),
                FamilyQueryBuilder::getDefaultFields()
            ),
            new StandardFamilyFactory()
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
        $family = $this->repository->findOneById(4);
        $this->assertInstanceOf(FamilyInterface::class, $family);

        $this->assertEquals(4, $family->getId());
        $this->assertEquals('Default', $family->getLabel());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByName()
    {
        $family = $this->repository->findOneByName('Default');
        $this->assertInstanceOf(FamilyInterface::class, $family);

        $this->assertEquals('Default', $family->getLabel());
        $this->assertEquals(4, $family->getId());
    }

    public function testFetchingOneByNameButNonExistent()
    {
        $this->assertNull($this->repository->findOneByName('Non existent'));
    }
}
