<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityAttribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Deleter\EntityAttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityAttributeDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class EntityAttributeDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityAttributeDeleterInterface
     */
    private $deleter;

    /**
     * @var LoaderInterface
     */
    private $fixturesLoader;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = $this->fixturesLoader->expectedDataSet(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getInitialDataSet()
    {
        $dataset = $this->fixturesLoader->initialDataSet(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

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
        $currentSchema = $this->getDoctrineConnection()->getSchemaManager()->createSchema();

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

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath(), 'eav_entity_attribute'),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->deleter = new EntityAttributeDeleter(
            $this->getDoctrineConnection(),
            new EntityAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                EntityAttributeQueryBuilder::getDefaultTable(),
                EntityAttributeQueryBuilder::getDefaultFields()
            )
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->deleter = null;
    }

    public function testRemoveNone()
    {
        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);

        $this->assertTableRowCount('eav_entity_attribute', $this->getInitialDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
