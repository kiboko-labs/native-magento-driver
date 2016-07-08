<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityStore;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\EntityStorePersisterInterface;
use Kiboko\Component\MagentoDriver\Deleter\EntityStoreDeleterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Entity\StandardEntityStorePersister;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityStoreDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class EntityStoreDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityStoreDeleterInterface
     */
    private $deleter;

    /**
     * @var EntityStorePersisterInterface
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
            'eav_entity_store',
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
            'eav_entity_store',
            DoctrineSchemaBuilder::CONTEXT_DELETER
        );

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_store')
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
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureEntityStoreTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath(), 'eav_entity_store'),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'eav_entity_store',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityStoreTable(
            'eav_entity_store',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new StandardEntityStorePersister(
            $this->getDoctrineConnection(),
            EntityStoreQueryBuilder::getDefaultTable()
        );

        $this->deleter = new EntityStoreDeleter(
            $this->getDoctrineConnection(),
            new EntityStoreQueryBuilder(
                $this->getDoctrineConnection(),
                EntityStoreQueryBuilder::getDefaultTable(),
                EntityStoreQueryBuilder::getDefaultFields()
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
        $actual->addTable('eav_entity_store');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);

        $this->assertTableRowCount('eav_entity_store', $this->getInitialDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_entity_store', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_entity_store', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }
}
