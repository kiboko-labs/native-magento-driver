<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\Entity;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\EntityStore;
use Kiboko\Component\MagentoDriver\Persister\EntityStorePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Entity\StandardEntityStorePersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class EntityStorePersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

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
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
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
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityTypeTable(
            'eav_entity_type',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityStoreTable(
            'eav_entity_type',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new StandardEntityStorePersister(
            $this->getDoctrineConnection(),
            EntityStoreQueryBuilder::getDefaultTable()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_entity_store' => [
                [
                    'entity_store_id' => 1,
                    'entity_type_id' => 1,
                    'store_id' => 0,
                    'increment_prefix' => '0',
                    'increment_last_id' => '000004372',
                ],
                [
                    'entity_store_id' => 2,
                    'entity_type_id' => 4,
                    'store_id' => 0,
                    'increment_prefix' => '5',
                    'increment_last_id' => '50000047W',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist($entityStore = new EntityStore(
            4,          // EntityTypeId
            1,          // StoreId
            '1',        // IncrementPrefix
            '100000001' // IncrementLastId
        ));
        $this->persister->flush();

        $this->assertEquals(3, $entityStore->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_entity_store' => [
                [
                    'entity_store_id' => 1,
                    'entity_type_id' => 1,
                    'store_id' => 0,
                    'increment_prefix' => '0',
                    'increment_last_id' => '000004372',
                ],
                [
                    'entity_store_id' => 2,
                    'entity_type_id' => 4,
                    'store_id' => 0,
                    'increment_prefix' => '5',
                    'increment_last_id' => '50000047W',
                ],
                [
                    'entity_store_id' => 3,
                    'entity_type_id' => 4,
                    'store_id' => 1,
                    'increment_prefix' => '1',
                    'increment_last_id' => '100000001',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        $this->persister->persist($entityStore = EntityStore::buildNewWith(
            2,          // EntityStoreId
            4,          // EntityTypeId
            0,          // StoreId
            '1',        // IncrementPrefix
            '100000001' // IncrementLastId
        ));
        $this->persister->flush();

        $this->assertEquals(2, $entityStore->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_entity_store' => [
                [
                    'entity_store_id' => 1,
                    'entity_type_id' => 1,
                    'store_id' => 0,
                    'increment_prefix' => '0',
                    'increment_last_id' => '000004372',
                ],
                [
                    'entity_store_id' => 2,
                    'entity_type_id' => 4,
                    'store_id' => 0,
                    'increment_prefix' => '1',
                    'increment_last_id' => '100000001',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_store');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
