<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Factory\StandardFamilyFactory;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilder;
use Luni\Component\MagentoDriver\Repository\Doctrine\FamilyRepository;
use Luni\Component\MagentoDriver\Repository\FamilyRepositoryInterface;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class FamilyRepositoryTest
    extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var FamilyRepositoryInterface
     */
    private $repository;

    /**
     * @var array
     */
    private $entityTypeData = [
        [
            'entity_type_id'              => 4,
            'entity_type_code'            => 'catalog_product',
            'entity_model'                => 'catalog/product',
            'attribute_model'             => 'catalog/resource_eav_attribute',
            'entity_table'                => 'catalog/product',
            'value_table_prefix'          => null,
            'entity_id_field'             => null,
            'is_data_sharing'             => 1,
            'data_sharing_key'            => 'default',
            'default_attribute_set_id'    => 4,
            'increment_model'             => null,
            'increment_per_store'         => 0,
            'increment_pad_length'        => 8,
            'increment_pad_char'          => 0,
            'additional_attribute_table'  => 'catalog/eav_attribute',
            'entity_attribute_collection' => 'catalog/product_attribute_collection',
        ],
    ];

    private $familiesData = [
        [
            'attribute_set_id'   => 4,
            'entity_type_id'     => 4,
            'attribute_set_name' => 'Default',
            'sort_order'         => 1,
        ],
        [
            'attribute_set_id'   => 5,
            'entity_type_id'     => 4,
            'attribute_set_name' => 'T-Shirt',
            'sort_order'         => 1,
        ],
        [
            'attribute_set_id'   => 6,
            'entity_type_id'     => 4,
            'attribute_set_name' => 'Jeans',
            'sort_order'         => 1,
        ],
    ];

    private function truncateTables()
    {
        $platform = $this->getConnection()->getDatabasePlatform();

        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute_set')
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();

        $this->initConnection();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->connection, $this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureFamilyTable();
        $schemaBuilder->ensureFamilyToEntityTypeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        foreach ($this->entityTypeData as $row) {
            $this->getConnection()->insert('eav_entity_type', $row);
        }

        foreach ($this->familiesData as $row) {
            $this->getConnection()->insert('eav_attribute_set', $row);
        }

        $this->repository = new FamilyRepository(
            $this->getConnection(),
            new FamilyQueryBuilder(
                $this->getConnection(),
                FamilyQueryBuilder::getDefaultTable(),
                FamilyQueryBuilder::getDefaultFields()
            ),
            new StandardFamilyFactory()
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        $this->closeConnection();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneById()
    {
        $family = $this->repository->findOneById(6);
        $this->assertInstanceOf(FamilyInterface::class, $family);

        $this->assertEquals($family->getId(), 6);
        $this->assertEquals($family->getLabel(), 'Jeans');
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByName()
    {
        $family = $this->repository->findOneByName('T-Shirt');
        $this->assertInstanceOf(FamilyInterface::class, $family);

        $this->assertEquals($family->getLabel(), 'T-Shirt');
        $this->assertEquals($family->getId(), 5);
    }

    public function testFetchingOneByNameButNonExistent()
    {
        $this->assertNull($this->repository->findOneByName('Non existent'));
    }
}