<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\AttributeLabel;
use Kiboko\Component\MagentoDriver\Persister\AttributeLabelPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeLabelPersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

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

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateStoreTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
        );

        $schemaBuilder->hydrateAttributeLabelTable(
            'eav_attribute_label',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER,
            $GLOBALS['MAGENTO_VERSION'],
            $GLOBALS['MAGENTO_EDITION']
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
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();

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
        $this->persister->flush();

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
        $this->persister->flush();

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
