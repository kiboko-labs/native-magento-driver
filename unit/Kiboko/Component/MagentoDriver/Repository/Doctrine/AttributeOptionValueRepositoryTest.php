<?php

namespace unit\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Factory\AttributeOptionValueFactory;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilder;
use Kiboko\Component\MagentoDriver\Repository\Doctrine\AttributeOptionValueRepository;
use Kiboko\Component\MagentoDriver\Repository\AttributeOptionValueRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table\Store as TableStore;

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
            $platform->getTruncateTableSQL(TableStore::getTableName($GLOBALS['MAGENTO_VERSION']))
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
            $this->getDoctrineConnection(), $this->schema, $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

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
