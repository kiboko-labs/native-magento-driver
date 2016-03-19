<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilder;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository;
use unit\Luni\Component\MagentoDriver\SchemaBuilder\DoctrineSchemaBuilder;
use unit\Luni\Component\MagentoDriver\DoctrineTools\DatabaseConnectionAwareTrait;

class ProductAttributeRepositoryTest
    extends \PHPUnit_Framework_TestCase
{
    use DatabaseConnectionAwareTrait;

    const TEST_ENTITY_TYPE_ID_1 = 4;

    const TEST_ATTRIBUTE_ID_1 = 4;
    const TEST_ATTRIBUTE_ID_2 = 8;

    const TEST_ATTRIBUTE_CODE_1 = 'size';
    const TEST_ATTRIBUTE_CODE_2 = 'special_to_date';

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var AttributeRepositoryInterface
     */
    private $repository;

    /**
     * @var array
     */
    private $entityTypeData = [
        [
            'entity_type_id'              => self::TEST_ENTITY_TYPE_ID_1,
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

    /**
     * @var array
     */
    private $attributeData = [
        [
            'attribute_id'    => self::TEST_ATTRIBUTE_ID_1,
            'entity_type_id'  => self::TEST_ENTITY_TYPE_ID_1,
            'attribute_code'  => self::TEST_ATTRIBUTE_CODE_1,
            'attribute_model' => null,
            'backend_model'   => null,
            'backend_type'    => 'int',
            'backend_table'   => null,
            'frontend_model'  => null,
            'frontend_input'  => 'select',
            'frontend_label'  => 'Size',
            'frontend_class'  => null,
            'source_model'    => 'eav/entity_attribute_source_table',
            'is_required'     => 0,
            'is_user_defined' => 1,
            'default_value'   => null,
            'is_unique'       => 0,
            'note'            => null,
        ],
        [
            'attribute_id'    => self::TEST_ATTRIBUTE_ID_2,
            'entity_type_id'  => self::TEST_ENTITY_TYPE_ID_1,
            'attribute_code'  => self::TEST_ATTRIBUTE_CODE_2,
            'attribute_model' => null,
            'backend_model'   => 'eav/entity_attribute_backend_datetime',
            'backend_type'    => 'datetime',
            'backend_table'   => null,
            'frontend_model'  => null,
            'frontend_input'  => 'date',
            'frontend_label'  => 'Special Price To Date',
            'frontend_class'  => null,
            'source_model'    => null,
            'is_required'     => 0,
            'is_user_defined' => 0,
            'default_value'   => null,
            'is_unique'       => 0,
            'note'            => null,
        ],
    ];

    /**
     * @var array
     */
    private $catalogAttributeData = [
        [
            'attribute_id'                  => self::TEST_ATTRIBUTE_ID_1,
            'frontend_input_renderer'       => null,
            'is_global'                     => 1,
            'is_visible'                    => 1,
            'is_searchable'                 => 0,
            'is_filterable'                 => 0,
            'is_comparable'                 => 0,
            'is_visible_on_front'           => 1,
            'is_html_allowed_on_front'      => 0,
            'is_used_for_price_rules'       => 0,
            'is_filterable_in_search'       => 0,
            'used_in_product_listing'       => 1,
            'used_for_sort_by'              => 1,
            'is_configurable'               => 1,
            'apply_to'                      => null,
            'is_visible_in_advanced_search' => 0,
            'position'                      => 0,
            'is_wysiwyg_enabled'            => 0,
            'is_used_for_promo_rules'       => 0
        ],
        [
            'attribute_id'                  => self::TEST_ATTRIBUTE_ID_2,
            'frontend_input_renderer'       => null,
            'is_global'                     => 1,
            'is_visible'                    => 1,
            'is_searchable'                 => 0,
            'is_filterable'                 => 0,
            'is_comparable'                 => 0,
            'is_visible_on_front'           => 1,
            'is_html_allowed_on_front'      => 0,
            'is_used_for_price_rules'       => 0,
            'is_filterable_in_search'       => 0,
            'used_in_product_listing'       => 1,
            'used_for_sort_by'              => 1,
            'is_configurable'               => 1,
            'apply_to'                      => null,
            'is_visible_in_advanced_search' => 0,
            'position'                      => 0,
            'is_wysiwyg_enabled'            => 0,
            'is_used_for_promo_rules'       => 0
        ],
    ];

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
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

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('catalog_eav_attribute')
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
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogAttributeExtensionsTable();
        $schemaBuilder->ensureAttributeToEntityTypeLinks();
        $schemaBuilder->ensureCatalogAttributeExtensionsToAttributeLinks();

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        foreach ($this->entityTypeData as $row) {
            $this->getConnection()->insert('eav_entity_type', $row);
        }

        foreach ($this->attributeData as $row) {
            $this->getConnection()->insert('eav_attribute', $row);
        }

        foreach ($this->catalogAttributeData as $row) {
            $this->getConnection()->insert('catalog_eav_attribute', $row);
        }

        $this->repository = new ProductAttributeRepository(
            $this->getConnection(),
            new ProductAttributeQueryBuilder(
                $this->getConnection(),
                ProductAttributeQueryBuilder::getDefaultTable(),
                ProductAttributeQueryBuilder::getDefaultExtraTable(),
                ProductAttributeQueryBuilder::getDefaultEntityTable(),
                ProductAttributeQueryBuilder::getDefaultVariantTable(),
                ProductAttributeQueryBuilder::getDefaultFamilyTable(),
                ProductAttributeQueryBuilder::getDefaultFields(),
                ProductAttributeQueryBuilder::getDefaultExtraFields()
            )
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
        $attribute = $this->repository->findOneById(self::TEST_ATTRIBUTE_ID_1);
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals($attribute->getId(), self::TEST_ATTRIBUTE_ID_1);
        $this->assertEquals($attribute->getCode(), self::TEST_ATTRIBUTE_CODE_1);
    }

    public function testFetchingOneByIdButNonExistent()
    {
        $this->assertNull($this->repository->findOneById(123));
    }

    public function testFetchingOneByCode()
    {
        $attribute = $this->repository->findOneByCode(self::TEST_ATTRIBUTE_CODE_2, 'catalog_product');
        $this->assertInstanceOf(AttributeInterface::class, $attribute);

        $this->assertEquals($attribute->getCode(), self::TEST_ATTRIBUTE_CODE_2);
        $this->assertEquals($attribute->getId(), self::TEST_ATTRIBUTE_ID_2);
    }

    public function testFetchingOneByCodeButNonExistent()
    {
        $this->assertNull($this->repository->findOneByCode('non_existent', 'catalog_product'));
    }
}