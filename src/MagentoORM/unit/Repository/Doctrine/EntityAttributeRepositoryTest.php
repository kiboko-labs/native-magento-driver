<?php

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\EntityAttributeFactory;
use Kiboko\Component\MagentoORM\Model\EntityAttributeInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\EntityAttributeRepository;
use Kiboko\Component\MagentoORM\Repository\EntityAttributeRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

class EntityAttributeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityAttributeRepositoryInterface
     *
     * @todo
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
                $platform->getTruncateTableSQL('eav_attribute_group')
        );

        $this->getDoctrineConnection()->exec(
                $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
                $platform->getTruncateTableSQL('eav_entity_attribute')
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

        $schemaBuilder->ensureAttributeGroupTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureEntityAttributeTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateEntityAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new EntityAttributeRepository(
            $this->getDoctrineConnection(),
            new EntityAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                EntityAttributeQueryBuilder::getDefaultTable(),
                EntityAttributeQueryBuilder::getDefaultFields()
            ),
            new EntityAttributeFactory()
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
        $entityAttribute = $this->repository->findOneById(6);

        $this->assertInstanceOf(EntityAttributeInterface::class, $entityAttribute);

        $this->assertEquals(6, $entityAttribute->getId());
        $this->assertEquals(4, $entityAttribute->getTypeId());
        $this->assertEquals(4, $entityAttribute->getAttributeSetId());
        $this->assertEquals(7, $entityAttribute->getAttributeGroupId());
        $this->assertEquals(226, $entityAttribute->getAttributeId());
        $this->assertEquals(60, $entityAttribute->getSortOrder());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(1337));
    }

    public function testFetchingAll()
    {
        $entityAttribute = $this->repository->findAll();
        $this->assertTrue(is_array($entityAttribute));
        foreach ($entityAttribute as $singleEntityAttribute) {
            $this->assertInstanceOf(EntityAttributeInterface::class, $singleEntityAttribute);
        }
        $this->assertGreaterThanOrEqual(1, count($entityAttribute));
    }

    public function testFetchingOneByAttributeIdAndGroupId()
    {
        $entityAttribute = $this->repository->findOneByAttributeIdAndGroupId(79, 7);

        $this->assertInstanceOf(EntityAttributeInterface::class, $entityAttribute);

        $this->assertEquals(1, $entityAttribute->getId());
        $this->assertEquals(4, $entityAttribute->getTypeId());
        $this->assertEquals(4, $entityAttribute->getAttributeSetId());
        $this->assertEquals(7, $entityAttribute->getAttributeGroupId());
        $this->assertEquals(79, $entityAttribute->getAttributeId());
        $this->assertEquals(10, $entityAttribute->getSortOrder());
    }

    public function testFetchingOneByAttributeIdAndSetId()
    {
        $entityAttribute = $this->repository->findOneByAttributeIdAndSetId(131, 4);

        $this->assertInstanceOf(EntityAttributeInterface::class, $entityAttribute);

        $this->assertEquals(3, $entityAttribute->getId());
        $this->assertEquals(4, $entityAttribute->getTypeId());
        $this->assertEquals(4, $entityAttribute->getAttributeSetId());
        $this->assertEquals(7, $entityAttribute->getAttributeGroupId());
        $this->assertEquals(131, $entityAttribute->getAttributeId());
        $this->assertEquals(30, $entityAttribute->getSortOrder());
    }
}
