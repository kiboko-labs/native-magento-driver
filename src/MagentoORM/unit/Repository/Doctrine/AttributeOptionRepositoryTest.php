<?php

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\AttributeOptionFactory;
use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\AttributeOptionRepository;
use Kiboko\Component\MagentoORM\Repository\AttributeOptionRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;

class AttributeOptionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeOptionRepositoryInterface
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
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_option')
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
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeOptionTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeOptionTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new AttributeOptionRepository(
            $this->getDoctrineConnection(),
            new AttributeOptionQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeOptionQueryBuilder::getDefaultTable(),
                AttributeOptionQueryBuilder::getDefaultFields()
            ),
            new AttributeOptionFactory()
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
        $attributeOption = $this->repository->findOneById(2);
        $this->assertInstanceOf(AttributeOptionInterface::class, $attributeOption);

        $this->assertEquals(2, $attributeOption->getId());
        $this->assertEquals(226, $attributeOption->getAttributeId());
        $this->assertEquals(10, $attributeOption->getSortOrder());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }
}
