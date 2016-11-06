<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\AttributeOption;
use Kiboko\Component\MagentoDriver\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeOptionPersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class AttributeOptionPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

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
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([]);

        return $dataSet;
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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $GLOBALS['MAGENTO_VERSION'], $GLOBALS['MAGENTO_EDITION']);
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
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeOptionTable(
            'eav_attribute_option',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new AttributeOptionPersister(
            $this->getDoctrineConnection(),
            AttributeOptionQueryBuilder::getDefaultTable()
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
            'eav_attribute_option' => [
                [
                    'option_id' => 1,
                    'attribute_id' => 226,
                    'sort_order' => 0,
                ],
                [
                    'option_id' => 2,
                    'attribute_id' => 226,
                    'sort_order' => 10,
                ],
                [
                    'option_id' => 3,
                    'attribute_id' => 226,
                    'sort_order' => 20,
                ],
                [
                    'option_id' => 4,
                    'attribute_id' => 226,
                    'sort_order' => 30,
                ],
                [
                    'option_id' => 5,
                    'attribute_id' => 226,
                    'sort_order' => 40,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist($attributeOption = new AttributeOption(
            226,
            50
        ));
        $this->persister->flush();

        $this->assertEquals(6, $attributeOption->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_option' => [
                [
                    'option_id' => 1,
                    'attribute_id' => 226,
                    'sort_order' => 0,
                ],
                [
                    'option_id' => 2,
                    'attribute_id' => 226,
                    'sort_order' => 10,
                ],
                [
                    'option_id' => 3,
                    'attribute_id' => 226,
                    'sort_order' => 20,
                ],
                [
                    'option_id' => 4,
                    'attribute_id' => 226,
                    'sort_order' => 30,
                ],
                [
                    'option_id' => 5,
                    'attribute_id' => 226,
                    'sort_order' => 40,
                ],
                [
                    'option_id' => 6,
                    'attribute_id' => 226,
                    'sort_order' => 50,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        $this->persister->persist(AttributeOption::buildNewWith(
            1,
            226,
            50
        ));
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_option' => [
                [
                    'option_id' => 1,
                    'attribute_id' => 226,
                    'sort_order' => 50,
                ],
                [
                    'option_id' => 2,
                    'attribute_id' => 226,
                    'sort_order' => 10,
                ],
                [
                    'option_id' => 3,
                    'attribute_id' => 226,
                    'sort_order' => 20,
                ],
                [
                    'option_id' => 4,
                    'attribute_id' => 226,
                    'sort_order' => 30,
                ],
                [
                    'option_id' => 5,
                    'attribute_id' => 226,
                    'sort_order' => 40,
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
