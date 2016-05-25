<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityStore;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\EntityStorePersisterInterface;
use Kiboko\Component\MagentoDriver\Deleter\EntityStoreDeleterInterface;
use Kiboko\Component\MagentoDriver\Persister\Direct\Entity\StandardEntityStorePersister;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\EntityStoreDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

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
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                $this->getDeleterFixturesPathname('eav_entity_store', '1.9', 'ce'));

        return $dataset;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getOriginalDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                $this->getFixturesPathname('eav_entity_store', '1.9', 'ce'));

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

        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');
        $schemaBuilder->hydrateEntityStoreTable('1.9', 'ce');

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

        $this->assertDataSetsEqual($this->getOriginalDataSet(), $actual);

        $this->assertTableRowCount('eav_entity_store', 9);
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
