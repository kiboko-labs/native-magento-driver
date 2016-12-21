<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoORM\Persister\V2_0ce\StandardDML\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Model\AttributeLabel;
use Kiboko\Component\MagentoORM\Persister\AttributeLabelPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDML\Attribute\AttributeLabelPersister;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class AttributeLabelPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeLabelPersisterInterface
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
            $platform->getTruncateTableSQL(StoreTableSchemaBuilder::getTableName($this->getVersion()))
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

        $schemaBuilder = new DoctrineSchemaBuilder(
            $this->getDoctrineConnection(), $this->schema, $this->getVersion(), $this->getEdition());
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

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $this->getVersion(),
            $this->getEdition()
        );

        $schemaBuilder->hydrateStoreTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeLabelTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new AttributeLabelPersister(
            $this->getDoctrineConnection(),
            AttributeLabelQueryBuilder::getDefaultTable()
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
            'eav_attribute_label' => [
                [
                    'attribute_label_id' => 1,
                    'attribute_id' => 79,
                    'store_id' => 1,
                    'value' => 'Cout',
                ],
                [
                    'attribute_label_id' => 2,
                    'attribute_id' => 122,
                    'store_id' => 1,
                    'value' => 'Laisser un message cadeau',
                ],
                [
                    'attribute_label_id' => 3,
                    'attribute_id' => 131,
                    'store_id' => 1,
                    'value' => null,
                ],
                [
                    'attribute_label_id' => 4,
                    'attribute_id' => 210,
                    'store_id' => 1,
                    'value' => 'Description',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $this->persister->persist($attributeLabel = new AttributeLabel(
            79, 2, 'Prix d\'achat'
        ));
        foreach ($this->persister->flush() as $item);

        $this->assertEquals(5, $attributeLabel->getId());

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_label' => [
                [
                    'attribute_label_id' => 1,
                    'attribute_id' => 79,
                    'store_id' => 1,
                    'value' => 'Cout',
                ],
                [
                    'attribute_label_id' => 2,
                    'attribute_id' => 122,
                    'store_id' => 1,
                    'value' => 'Laisser un message cadeau',
                ],
                [
                    'attribute_label_id' => 3,
                    'attribute_id' => 131,
                    'store_id' => 1,
                    'value' => null,
                ],
                [
                    'attribute_label_id' => 4,
                    'attribute_id' => 210,
                    'store_id' => 1,
                    'value' => 'Description',
                ],
                [
                    'attribute_label_id' => 5,
                    'attribute_id' => 79,
                    'store_id' => 2,
                    'value' => 'Prix d\'achat',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        $this->persister->persist(AttributeLabel::buildNewWith(
            1, 79, 1, 'Prix d\'achat'
        ));
        foreach ($this->persister->flush() as $item);

        $expected = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'eav_attribute_label' => [
                [
                    'attribute_label_id' => 1,
                    'attribute_id' => 79,
                    'store_id' => 1,
                    'value' => 'Prix d\'achat',
                ],
                [
                    'attribute_label_id' => 2,
                    'attribute_id' => 122,
                    'store_id' => 1,
                    'value' => 'Laisser un message cadeau',
                ],
                [
                    'attribute_label_id' => 3,
                    'attribute_id' => 131,
                    'store_id' => 1,
                    'value' => null,
                ],
                [
                    'attribute_label_id' => 4,
                    'attribute_id' => 210,
                    'store_id' => 1,
                    'value' => 'Description',
                ],
            ],
        ]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_label');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
