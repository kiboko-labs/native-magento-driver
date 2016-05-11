<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Factory\AttributeGroupFactory;
use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;
use Luni\Component\MagentoDriver\Repository\Doctrine\AttributeGroupRepository;
use Luni\Component\MagentoDriver\Repository\AttributeGroupRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class AttributeGroupRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeGroupRepositoryInterface
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
            $platform->getTruncateTableSQL('eav_attribute_set')
        );
        
        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_group')
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
        $schemaBuilder->ensureAttributeGroupTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();
        $schemaBuilder->hydrateFamilyTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeGroupTable('1.9', 'ce');

        $this->repository = new AttributeGroupRepository(
            $this->getDoctrineConnection(),
            new AttributeGroupQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeGroupQueryBuilder::getDefaultTable(),
                AttributeGroupQueryBuilder::getDefaultFields()
            ),
            new AttributeGroupFactory()
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
        $family = $this->repository->findOneById(6);
        $this->assertInstanceOf(AttributeGroupInterface::class, $family);
        
        $this->assertEquals($family->getId(), 6);
        $this->assertEquals($family->getFamilyId(), 3);
        $this->assertEquals($family->getLabel(), 'Custom Design');
        $this->assertEquals($family->getSortOrder(), 30);
        $this->assertEquals($family->getDefaultId(), 0);
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByName()
    {
        $family = $this->repository->findOneByName('Custom Design');
        $this->assertInstanceOf(AttributeGroupInterface::class, $family);

        $this->assertEquals($family->getLabel(), 'Custom Design');

        $this->assertEquals($family->getId(), 6);
        $this->assertEquals($family->getFamilyId(), 3);
        $this->assertEquals($family->getSortOrder(), 30);
        $this->assertEquals($family->getDefaultId(), 0);
    }

    public function testFetchingOneByNameButNonExistent()
    {
        $this->assertNull($this->repository->findOneByName('Non existent'));
    }
}
