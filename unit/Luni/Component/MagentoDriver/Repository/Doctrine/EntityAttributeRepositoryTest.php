<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Factory\EntityAttributeFactory;
use Luni\Component\MagentoDriver\Model\EntityAttributeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use Luni\Component\MagentoDriver\Repository\Doctrine\EntityAttributeRepository;
use Luni\Component\MagentoDriver\Repository\EntityAttributeRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

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

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);

        $schemaBuilder->ensureAttributeGroupTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureEntityAttributeTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();
        
        $magentoVersion = '1.9';
        $magentoEdition = 'ce';
        
        $schemaBuilder->hydrateAttributeGroupTable($magentoVersion, $magentoEdition);
        $schemaBuilder->hydrateAttributeTable($magentoVersion, $magentoEdition);
        $schemaBuilder->hydrateEntityAttributeTable($magentoVersion, $magentoEdition);

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
    }

    public function testFetchingOneById()
    {
        $entityAttribute = $this->repository->findOneById(6);

        $this->assertInstanceOf(EntityAttributeInterface::class, $entityAttribute);

        $this->assertEquals($entityAttribute->getId(), 6);
        $this->assertEquals($entityAttribute->getTypeId(), 4);
        $this->assertEquals($entityAttribute->getAttributeSetId(), 4);
        $this->assertEquals($entityAttribute->getAttributeGroupId(), 7);
        $this->assertEquals($entityAttribute->getAttributeId(), 226);
        $this->assertEquals($entityAttribute->getSortOrder(), 60);
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

        $this->assertEquals($entityAttribute->getId(), 1);
        $this->assertEquals($entityAttribute->getTypeId(), 4);
        $this->assertEquals($entityAttribute->getAttributeSetId(), 4);
        $this->assertEquals($entityAttribute->getAttributeGroupId(), 7);
        $this->assertEquals($entityAttribute->getAttributeId(), 79);
        $this->assertEquals($entityAttribute->getSortOrder(), 10);
    }
    
    public function testFetchingOneByAttributeIdAndSetId()
    {
        $entityAttribute = $this->repository->findOneByAttributeIdAndSetId(131, 4);

        $this->assertInstanceOf(EntityAttributeInterface::class, $entityAttribute);

        $this->assertEquals($entityAttribute->getId(), 3);
        $this->assertEquals($entityAttribute->getTypeId(), 4);
        $this->assertEquals($entityAttribute->getAttributeSetId(), 4);
        $this->assertEquals($entityAttribute->getAttributeGroupId(), 7);
        $this->assertEquals($entityAttribute->getAttributeId(), 131);
        $this->assertEquals($entityAttribute->getSortOrder(), 30);
    }
}
