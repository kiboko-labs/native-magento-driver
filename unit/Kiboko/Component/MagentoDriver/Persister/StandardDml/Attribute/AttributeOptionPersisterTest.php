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
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

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
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_option', '1.9', 'ce'));

        return $dataset;
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

        $schemaBuilder = new DoctrineSchemaBuilder($this->getDoctrineConnection(), $this->schema);
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeOptionTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

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

        $this->assertTableRowCount('eav_attribute_option', 0);
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute_option');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = AttributeOption::buildNewWith(
                $data['option_id'],
                $data['attribute_id'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_option', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute_option');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = AttributeOption::buildNewWith(
                $data['option_id'],
                $data['attribute_id'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_option', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_option');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
