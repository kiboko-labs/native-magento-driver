<?php

namespace unit\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Factory\AttributeOptionValueFactory;
use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilder;
use Kiboko\Component\MagentoORM\Repository\Doctrine\AttributeOptionValueRepository;
use Kiboko\Component\MagentoORM\Repository\AttributeOptionValueRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class AttributeOptionValueRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeOptionValueRepositoryInterface
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
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_option')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL(StoreTableSchemaBuilder::getTableName($this->getVersion()))
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_option_value')
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
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureAttributeOptionValueTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeOptionTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateStoreTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $schemaBuilder->hydrateAttributeOptionValueTable(
            'eav_attribute_option_value',
            DoctrineSchemaBuilder::CONTEXT_REPOSITORY
        );

        $this->repository = new AttributeOptionValueRepository(
            $this->getDoctrineConnection(),
            new AttributeOptionValueQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeOptionValueQueryBuilder::getDefaultTable(),
                AttributeOptionValueQueryBuilder::getDefaultFields()
            ),
            new AttributeOptionValueFactory()
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
        $attributeOptionValue = $this->repository->findOneById(2);
        $this->assertInstanceOf(AttributeOptionValueInterface::class, $attributeOptionValue);

        $this->assertEquals(2, $attributeOptionValue->getId());
        $this->assertEquals(1, $attributeOptionValue->getOptionId());
        $this->assertEquals(1, $attributeOptionValue->getStoreId());
        $this->assertEquals('Rouge', $attributeOptionValue->getValue());
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }
}
