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
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

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
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_attribute', '1.9', 'ce'));

        return $dataset;
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

        $this->assertTableRowCount('eav_entity_attribute', 0);
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_entity_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = EntityAttribute::buildNewWith(
                $data['entity_attribute_id'],
                $data['entity_type_id'],
                $data['attribute_set_id'],
                $data['attribute_group_id'],
                $data['attribute_id'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_attribute', '1.9', 'ce')
        );

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');

        $this->assertDataSetsEqual($expected, $actual);

        $this->assertTableRowCount('eav_entity_attribute', $this->getDataSet()->getIterator()->getTable()->getRowCount());
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_entity_attribute');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = EntityAttribute::buildNewWith(
                $data['entity_attribute_id'],
                $data['entity_type_id'],
                $data['attribute_set_id'],
                $data['attribute_group_id'],
                $data['attribute_id'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_entity_attribute', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_entity_attribute');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
