<?php

namespace unit\Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Model\Attribute;
use Kiboko\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\StandardAttributePersister;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

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
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_type', '1.9', 'ce'));

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

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $schemaBuilder->hydrateEntityAttributeTable('1.9', 'ce');

        $this->truncateTables();

        parent::setUp();

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
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();

        $this->assertTableRowCount('eav_attribute', 0);
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = Attribute::buildNewWith(
                $data['attribute_id'],    // AttributeId
                $data['entity_type_id'],  // EntityTypeId
                $data['attribute_code'],  // Identifier
                $data['attribute_model'], // ModelClass
                $data['backend_type'],    // BackendType
                $data['backend_model'],   // BackendModelClass
                $data['backend_table'],   // BackendTable
                $data['frontend_input'],  // FrontedType
                $data['frontend_model'],  // FrontendModelClass
                $data['frontend_input'],  // FrontendInput
                $data['frontend_label'],  // FrontendLabel
                $data['frontend_class'],  // FrontendViewClass
                $data['source_model'],    // SourceModelClass
                $data['is_required'],     // IsRequired
                $data['is_user_defined'], // IsUserDefined
                $data['is_unique'],       // IsUnique
                $data['default_value'],   // IsDefaultValue
                $data['note']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = Attribute::buildNewWith(
                $data['attribute_id'],    // AttributeId
                $data['entity_type_id'],  // EntityTypeId
                $data['attribute_code'],  // Identifier
                $data['attribute_model'], // ModelClass
                $data['backend_type'],    // BackendType
                $data['backend_model'],   // BackendModelClass
                $data['backend_table'],   // BackendTable
                $data['frontend_input'],  // FrontedType
                $data['frontend_model'],  // FrontendModelClass
                $data['frontend_input'],  // FrontendInput
                $data['frontend_label'],  // FrontendLabel
                $data['frontend_class'],  // FrontendViewClass
                $data['source_model'],    // SourceModelClass
                $data['is_required'],     // IsRequired
                $data['is_user_defined'], // IsUserDefined
                $data['is_unique'],       // IsUnique
                $data['default_value'],   // IsDefaultValue
                $data['note']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
