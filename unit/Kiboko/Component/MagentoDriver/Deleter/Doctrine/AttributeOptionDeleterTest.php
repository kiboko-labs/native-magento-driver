<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoDriver\Deleter\AttributeOptionDeleterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeOptionPersister;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\AttributeOptionDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class AttributeOptionDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeOptionDeleterInterface
     */
    private $deleter;

    /**
     * @var AttributeOptionPersisterInterface
     */
    private $persister;

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
            'eav_attribute_option',
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
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

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
        $currentSchema = $this->getDoctrineConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeOptionTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath(), 'eav_attribute_option'),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeOptionTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new AttributeOptionPersister(
            $this->getDoctrineConnection(),
            AttributeOptionQueryBuilder::getDefaultTable()
        );

        $this->deleter = new AttributeOptionDeleter(
            $this->getDoctrineConnection(),
            new AttributeOptionQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeOptionQueryBuilder::getDefaultTable(),
                AttributeOptionQueryBuilder::getDefaultFields()
            )
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = $this->deleter = null;
    }

    public function testRemoveNone()
    {
        $this->persister->initialize();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_option', $this->getInitialDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_option', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_option', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }
}
