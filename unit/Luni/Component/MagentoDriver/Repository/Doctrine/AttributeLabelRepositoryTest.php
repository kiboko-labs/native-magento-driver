<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Factory\AttributeLabelFactory;
use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeLabelQueryBuilder;
use Luni\Component\MagentoDriver\Repository\Doctrine\AttributeLabelRepository;
use Luni\Component\MagentoDriver\Repository\AttributeLabelRepositoryInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class AttributeLabelRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeLabelRepositoryInterface
     */
    private $repository;

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $dataSet = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet();

        return $dataSet;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
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
        parent::setUp();
        
        $currentSchema = $this->getDoctrineConnection()
            ->getSchemaManager()
            ->createSchema()
        ;

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

        $schemaBuilder->hydrateStoreTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeTable('1.9', 'ce');
        $schemaBuilder->hydrateAttributeLabelTable('1.9', 'ce');

        $this->repository = new AttributeLabelRepository(
            $this->getDoctrineConnection(),
            new AttributeLabelQueryBuilder(
                $this->getDoctrineConnection(),
                AttributeLabelQueryBuilder::getDefaultTable(),
                AttributeLabelQueryBuilder::getDefaultFields()
            ),
            new AttributeLabelFactory()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneById()
    {
        $attributeLabel = $this->repository->findOneById(2);
        $this->assertInstanceOf(AttributeLabelInterface::class, $attributeLabel);
        
        $this->assertEquals($attributeLabel->getId(), 2);
        $this->assertEquals($attributeLabel->getAttributeId(), 122);
        $this->assertEquals($attributeLabel->getStoreId(), 1);
        $this->assertEquals($attributeLabel->getValue(), 'Laisser un message cadeau');
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

}
