<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Persister\Magento20\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Model\AttributeOption;
use Kiboko\Component\MagentoORM\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\AttributeOptionPersister;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;

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
     * @return string
     */
    private function getVersion()
    {
        return '2.0';
    }

    /**
     * @return string
     */
    private function getEdition()
    {
        return 'ce';
    }

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
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
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
            $this->getVersion(),
            $this->getEdition()
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
        $this->doctrineConnection = null;
        $this->connection = null;
        $this->pdo = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        foreach ($this->persister->flush() as $item);

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
        foreach ($this->persister->flush() as $item);

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
        foreach ($this->persister->flush() as $item);

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
