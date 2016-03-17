<?php

namespace unit\Luni\Component\MagentoDriver\Persister\Direct\Attribute;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Persister\AttributePersisterInterface;
use Luni\Component\MagentoDriver\Persister\Direct\Attribute\StandardAttributePersister;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class AttributePersisterTest
    extends \PHPUnit_Framework_TestCase
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

    private function truncateTables()
    {
        $platform = $this->getConnection()->getDatabasePlatform();

        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_entity_type')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->initConnection();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->schema);
        $schemaBuilder->ensureEntityTypeTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        $this->persister = new StandardAttributePersister(
            $this->getConnection(),
            ProductAttributeQueryBuilder::getDefaultTable()
        );

        $this->connection->insert(
            'eav_entity_type',
            [
                'entity_type_id'              => ProductInterface::ENTITY_TYPE_ID,
                'entity_type_code'            => ProductInterface::ENTITY_CODE,
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
            ]
        );
    }

    protected function tearDown()
    {
        $this->truncateTables();
        $this->closeConnection();
        parent::tearDown();

        $this->persister = null;
    }

    public function testInsertNone()
    {
        $this->persister->initialize();
        $this->persister->flush();
    }

    public function testInsertOneInteger()
    {
        $attribute = new Attribute(
            ProductInterface::ENTITY_TYPE_ID,       // entity_type_id
            'testing_integer',                      // attribute_code
            null,                                   // attribute_model
            'int',                                  // backend_type
            null,                                   // backend_model
            null,                                   // backend_table
            null,                                   // frontend_model
            'text',                                 // frontend_input
            'Testing integer',                      // frontend_label
            null,                                   // frontend_class
            null,                                   // source_model
            false,                                  // is_required
            false,                                  // is_user_defined
            false,                                  // is_unique
            '0',                                    // default_value
            null                                    // note
        );

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }

    public function testInsertOneSelectable()
    {
        $attribute = new Attribute(
            ProductInterface::ENTITY_TYPE_ID,       // entity_type_id
            'testing_selectable',                   // attribute_code
            null,                                   // attribute_model
            'int',                                  // backend_type
            null,                                   // backend_model
            null,                                   // backend_table
            null,                                   // frontend_model
            'select',                               // frontend_input
            'Testing selectable',                   // frontend_label
            null,                                   // frontend_class
            'eav/entity_attribute_source_table',    // source_model
            false,                                  // is_required
            true,                                   // is_user_defined
            false,                                  // is_unique
            '0',                                    // default_value
            null                                    // note
        );

        $this->persister->initialize();
        $this->persister->persist($attribute);
        $this->persister->flush();
    }
}
