<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\StandardAttributePersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;

use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

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
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet();

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
            $platform->getTruncateTableSQL('eav_attribute')
        );
        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();

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

        $this->truncateTables();
        $schemaBuilder->hydrateEntityTypeTable('1.9', 'ce');

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
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = new Attribute(
                $data['entity_type_id'],
                $data['attribute_code'],
                $data['attribute_model'],
                $data['backend_model'],
                $data['backend_type'],
                $data['backend_table'],
                $data['frontend_model'],
                $data['frontend_input'],
                $data['frontend_label'],
                $data['frontend_class'],
                $data['source_model'],
                $data['is_required'],
                $data['is_user_defined'],
                $data['default_value'],
                $data['is_unique'],
                $data['note']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet();
        $expected->addTable('eav_attribute',
            __DIR__ . '/../../../SchemaBuilder/Fixture/data-ce-1.9/eav_attribute.csv');

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
@            $attribute = Attribute::buildNewWith(
                $data['attribute_id'],
                $data['entity_type_id'],
                $data['attribute_code'],
                $data['attribute_model'],
                $data['backend_model'],
                $data['backend_type'],
                $data['backend_table'],
                $data['frontend_model'],
                $data['frontend_input'],
                $data['frontend_label'],
                $data['frontend_class'],
                $data['source_model'],
                $data['is_required'],
                $data['is_user_defined'],
                $data['default_value'],
                $data['is_unique'],
                $data['note']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();
    }
}
