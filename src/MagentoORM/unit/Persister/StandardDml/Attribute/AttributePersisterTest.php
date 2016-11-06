<?php

namespace unit\Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoORM\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\FallbackResolver;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\Loader;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture\LoaderInterface;

class AttributePersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributePersisterInterface
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
        $dataset = $this->fixturesLoader->initialDataSet(
            'eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

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
            $platform->getTruncateTableSQL('eav_attribute')
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
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();

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
            'eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $schemaBuilder->hydrateAttributeTable(
            'eav_attribute',
            DoctrineSchemaBuilder::CONTEXT_PERSISTER
        );

        $this->persister = new StandardAttributePersister(
            $this->getDoctrineConnection(),
            ProductAttributeQueryBuilder::getDefaultTable()
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

        $expected = $this->getDataSet();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testInsertOne()
    {
        $this->persister->initialize();
        $attribute = new Attribute(
            4,              // EntityTypeId
            'description',  // Identifier
            null,           // ModelClass
            'text',         // BackendType
            null,           // BackendModelClass
            null,           // BackendTable
            null,           // FrontendModelClass
            'text',         // FrontendInput
            'Description',  // FrontendLabel
            null,           // FrontendViewClass
            null,           // SourceModelClass
            0,              // IsRequired
            1,              // IsUserDefined
            0,              // IsUnique
            null,           // DefaultValue
            null
        );
        $this->persister->persist($attribute);
        foreach ($this->persister->flush() as $item);

        $this->assertEquals(80, $attribute->getId());

        $expected = $this->getDataSet();
        $expected->getTable('eav_attribute')->addRow(
                [
                    'attribute_id' => 80,
                    'entity_type_id' => 4,
                    'attribute_code' => 'description',
                    'attribute_model' => null,
                    'backend_model' => null,
                    'backend_type' => 'text',
                    'backend_table' => null,
                    'frontend_model' => null,
                    'frontend_input' => 'text',
                    'frontend_label' => 'Description',
                    'frontend_class' => null,
                    'source_model' => null,
                    'is_required' => 0,
                    'is_user_defined' => 1,
                    'default_value' => null,
                    'is_unique' => 0,
                    'note' => null,
                ]
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $this->persister->initialize();
        foreach ($this->persister->flush() as $item);

        $expected = $this->getDataSet();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');
        $actual->addTable('eav_entity_type');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
