<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\EntityAttribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\EntityAttribute;
use Kiboko\Component\MagentoDriver\Persister\EntityAttributePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardEntityAttributePersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class EntityAttributePersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var EntityAttributePersisterInterface
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
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateEntityAttributeTable(
            'eav_entity_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $this->persister = new StandardEntityAttributePersister(
            $this->getDoctrineConnection(),
            EntityAttributeQueryBuilder::getDefaultTable()
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

        $this->assertTableRowCount('eav_entity_attribute', 1);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();

        $this->persister->persist(EntityAttribute::buildNewWith(null, 4, 4, 7, 122, 20));

        $this->persister->flush();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_entity_attribute' => [
                [
                    'entity_attribute_id' => 1,
                    'entity_type_id' => 4,
                    'attribute_set_id' => 4,
                    'attribute_group_id' => 7,
                    'attribute_id' => 79,
                    'sort_order' => 10,
                ],
                [
                    'entity_attribute_id' => 2,
                    'entity_type_id' => 4,
                    'attribute_set_id' => 4,
                    'attribute_group_id' => 7,
                    'attribute_id' => 122,
                    'sort_order' => 20,
                ],
            ]
        ]);

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();

        $this->persister->persist(EntityAttribute::buildNewWith(1, 4, 4, 7, 79, 20));

        $this->persister->flush();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');


        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_entity_attribute' => [
                [
                    'entity_attribute_id' => 1,
                    'entity_type_id' => 4,
                    'attribute_set_id' => 4,
                    'attribute_group_id' => 7,
                    'attribute_id' => 79,
                    'sort_order' => 20,
                ],
            ]
        ]);

        $this->assertDataSetsEqual($expected, $actual);
    }
}
