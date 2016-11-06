<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace unit\Kiboko\Component\MagentoDriver\Persister\Magento19\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\Magento19\AttributeGroup;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Magento19\Attribute\AttributeGroupPersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\LoaderInterface;

class AttributeGroupPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeGroupPersisterInterface
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
        return '1.9';
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
        $dataset = $this->fixturesLoader->initialDataSet(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_set')
        );

        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_group')
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
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureAttributeGroupTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->fixturesLoader = new Loader(
            new FallbackResolver($schemaBuilder->getFixturesPath()),
            $this->getVersion(), $this->getEdition()
        );

        $schemaBuilder->hydrateAttributeGroupTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateFamilyTable(
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new AttributeGroupPersister(
            $this->getDoctrineConnection(),
            AttributeGroupQueryBuilder::getDefaultTable()
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

        $expected = $this->fixturesLoader->namedDataSet(
            'do-nothing',
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $attributeGroup = new AttributeGroup(3, 'Prices', 1, 1);

        $this->persister->initialize();
        $this->persister->persist($attributeGroup);
        foreach ($this->persister->flush() as $item);

        $this->assertNotNull($attributeGroup->getId());

        $expected = $this->fixturesLoader->namedDataSet(
            'insert-one',
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();

        $attributeGroup = AttributeGroup::buildNewWith(1, 1, 'Updated', 1, 1);

        $this->persister->persist($attributeGroup);
        foreach ($this->persister->flush() as $item);

        $this->assertEquals(1, $attributeGroup->getId());

        $expected = $this->fixturesLoader->namedDataSet(
            'update-one',
            'eav_attribute_group',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_group');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
