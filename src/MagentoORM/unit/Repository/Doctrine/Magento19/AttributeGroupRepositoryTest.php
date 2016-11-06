<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine\Magento19;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\Magento19\AttributeGroupFactory;
use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\AttributeGroupRepository;
use Kiboko\Component\MagentoORM\Repository\AttributeGroupRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

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
     * @return string
     */
    private function getVersion()
    {
        return '1.9';
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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureAttributeGroupTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateFamilyTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

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
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }

    public function testFetchingOneById()
    {
        $family = $this->repository->findOneById(6);
        $this->assertInstanceOf(AttributeGroupInterface::class, $family);

        $this->assertEquals(6, $family->getId());
        $this->assertEquals(3, $family->getFamilyId());
        $this->assertEquals('Custom Design', $family->getLabel());
        $this->assertEquals(30, $family->getSortOrder());
        $this->assertEquals(0, $family->getDefaultId());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByName()
    {
        $family = $this->repository->findOneByName('Custom Design');
        $this->assertInstanceOf(AttributeGroupInterface::class, $family);

        $this->assertEquals('Custom Design', $family->getLabel());

        $this->assertEquals(6, $family->getId());
        $this->assertEquals(3, $family->getFamilyId());
        $this->assertEquals(30, $family->getSortOrder());
        $this->assertEquals(0, $family->getDefaultId());
    }

    public function testFetchingOneByNameButNonExistent()
    {
        $this->assertNull($this->repository->findOneByName('Non existent'));
    }
}
