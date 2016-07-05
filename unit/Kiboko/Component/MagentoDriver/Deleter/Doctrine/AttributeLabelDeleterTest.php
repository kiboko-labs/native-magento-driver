<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;
use Kiboko\Component\MagentoDriver\Deleter\AttributeLabelDeleterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeLabelPersister;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\AttributeLabelDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class AttributeLabelDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeLabelDeleterInterface
     */
    private $deleter;

    /**
     * @var AttributeLabelPersisterInterface
     */
    private $persister;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = $this->fixturesLoader->getDataSet($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

        return $dataset;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getOriginalDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_label', $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']));

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('core_store')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_label')
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
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeLabelTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $schemaBuilder->hydrateStoreTable($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
        $schemaBuilder->hydrateAttributeTable($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
        $schemaBuilder->hydrateAttributeLabelTable($GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);

        $this->persister = new AttributeLabelPersister(
            $this->getDoctrineConnection(),
            AttributeLabelQueryBuilder::getDefaultTable()
        );

        $this->deleter = new AttributeLabelDeleter(
            $this->getDoctrineConnection(),
            new AttributeLabelQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeLabelQueryBuilder::getDefaultTable(),
                AttributeLabelQueryBuilder::getDefaultFields()
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
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($this->getOriginalDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_label', $this->getOriginalDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_label', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
        
        $this->assertTableRowCount('eav_attribute_label', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }
}
