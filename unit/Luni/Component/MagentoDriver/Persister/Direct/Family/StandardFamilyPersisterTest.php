<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Family;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\Family;
use Luni\Component\MagentoDriver\Persister\FamilyPersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Family\StandardFamilyPersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\Fixture\Loader;

class StandardFamilyPersisterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var FamilyPersisterInterface
     */
    private $persister;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_set', '1.9', 'ce'));

        return $dataset;
    }

    private function truncateTables()
    {
        $platform = $this->getDoctrineConnection()->getDatabasePlatform();

        $this->getDoctrineConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getDoctrineConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_set')
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
        $schemaBuilder->ensureFamilyTable();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getDoctrineConnection()->getDatabasePlatform()) as $sql) {
            $this->getDoctrineConnection()->exec($sql);
        }

        $this->truncateTables();

        parent::setUp();

        $this->persister = new StandardFamilyPersister(
            $this->getDoctrineConnection(),
            FamilyQueryBuilder::getDefaultTable()
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

        $this->assertTableRowCount('eav_attribute_set', 0);
    }

    public function testInsertOne()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute_set');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = Family::buildNewWith(
                $data['attribute_set_id'],
                $data['attribute_set_name'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_set', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($expected, $actual);
    }

    public function testUpdateOneExisting()
    {
        $dataLoader = new Loader($this->getDoctrineConnection(), 'eav_attribute_set');

        $this->persister->initialize();
        foreach ($dataLoader->walkData('1.9', 'ce') as $data) {
            $attribute = Family::buildNewWith(
                $data['attribute_set_id'],
                $data['attribute_set_name'],
                $data['sort_order']
            );
            $this->persister->persist($attribute);
        }
        $this->persister->flush();

        $expected = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            $this->getFixturesPathname('eav_attribute_set', '1.9', 'ce'));

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($expected, $actual);
    }
}
