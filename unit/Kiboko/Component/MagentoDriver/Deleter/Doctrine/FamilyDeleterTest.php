<?php

namespace unit\Kiboko\Component\MagentoDriver\Deleter\Doctrine\Family;

use Doctrine\DBAL\Schema\Schema;
use Kiboko\Component\MagentoDriver\Persister\FamilyPersisterInterface;
use Kiboko\Component\MagentoDriver\Deleter\FamilyDeleterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Family\StandardFamilyPersister;
use Kiboko\Component\MagentoDriver\Deleter\Doctrine\FamilyDeleter;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilder;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Kiboko\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Kiboko\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class FamilyDeleterTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var FamilyDeleterInterface
     */
    private $deleter;

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
                $this->getDeleterFixturesPathname('eav_attribute_set', '1.9', 'ce'));

        return $dataset;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getOriginalDataSet()
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

        $schemaBuilder->hydrateFamilyTable('1.9', 'ce');

        $this->persister = new StandardFamilyPersister(
            $this->getDoctrineConnection(),
            FamilyQueryBuilder::getDefaultTable()
        );

        $this->deleter = new FamilyDeleter(
            $this->getDoctrineConnection(),
            new FamilyQueryBuilder(
                $this->getDoctrineConnection(),
                FamilyQueryBuilder::getDefaultTable(),
                FamilyQueryBuilder::getDefaultFields()
            )
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();

        $this->persister = $this->deleter = null;
    }

    public function testRemoveNone()
    {
        $this->persister->initialize();

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($this->getOriginalDataSet(), $actual);
    }

    public function testRemoveOneById()
    {
        $this->persister->initialize();
        $this->deleter->deleteOneById(2);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }

    public function testRemoveAllById()
    {
        $this->persister->initialize();
        $this->deleter->deleteAllById([2]);

        $actual = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $actual->addTable('eav_attribute_set');

        $this->assertDataSetsEqual($this->getDataSet(), $actual);
    }
}
