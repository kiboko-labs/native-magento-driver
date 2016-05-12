<?php

namespace unit\Luni\Component\MagentoDriver\Deleter\Doctrine\Family;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;
use Luni\Component\MagentoDriver\Deleter\AttributeLabelDeleterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\AttributeLabelPersister;
use Luni\Component\MagentoDriver\Deleter\Doctrine\AttributeLabelDeleter;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

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
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                    $this->getDeleterFixturesPathname('eav_attribute_label', '1.9', 'ce'));

        return $dataset;
    }
    
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getOriginalDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                $this->getFixturesPathname('eav_attribute_label', '1.9', 'ce'));

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

        $schemaBuilder->hydrateStoreTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeLabelTable('1.9', 'ce');

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
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
    
    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById(array(2));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
