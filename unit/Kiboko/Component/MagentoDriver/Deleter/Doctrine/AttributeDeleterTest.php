<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoDriver\Deleter\AttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\AttributeDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class AttributeDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeDeleterInterface
     */
    private $deleter;

    /**
     * @var AttributePersisterInterface
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
            'eav_attribute',
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
            'eav_attribute',
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

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath(), 'eav_attribute'),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_DELETER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new StandardAttributePersister(
                $this->getDoctrineConnection(), ProductAttributeQueryBuilder::getDefaultTable()
        );

        $this->deleter = new AttributeDeleter(
            $this->getDoctrineConnection(),
            new ProductAttributeQueryBuilder(
                $this->getDoctrineConnection(),
                ProductAttributeQueryBuilder::getDefaultTable(),
                ProductAttributeQueryBuilder::getDefaultExtraTable(),
                ProductAttributeQueryBuilder::getDefaultEntityTable(),
                ProductAttributeQueryBuilder::getDefaultVariantTable(),
                ProductAttributeQueryBuilder::getDefaultFamilyTable(),
                ProductAttributeQueryBuilder::getDefaultFields(),
                ProductAttributeQueryBuilder::getDefaultExtraFields()
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
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getInitialDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute', $this->getInitialDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(79);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([79]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneByCode()
    {
        $this->persister->initialize();

        $this->deleter->deleteOneByCode('cost');

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveAllByCode()
    {
        $this->persister->initialize();

        $this->deleter->deleteAllByCode(['cost']);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }
}
