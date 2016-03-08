<?php

namespace unit\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilder;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use unit\Luni\Component\MagentoDriver\DoctrineSchemaBuilder;

class ProductAttributeDatetimeValueRepositoryTest
    extends AbstractRepositoryTestCase
{
    const TEST_STORE_ID_0 = 0;
    const TEST_STORE_ID_1 = 1;
    const TEST_STORE_ID_2 = 2;

    const TEST_ENTITY_TYPE_ID_1 = 1;

    const TEST_ATTRIBUTE_SET_ID_1 = 4;
    const TEST_ATTRIBUTE_SET_ID_2 = 5;

    const TEST_ATTRIBUTE_ID_1 = 4;
    const TEST_ATTRIBUTE_ID_2 = 8;

    const TEST_ATTRIBUTE_CODE_1 = 'special_from_date';
    const TEST_ATTRIBUTE_CODE_2 = 'special_to_date';

    const TEST_ENTITY_ID_1 = 123;
    const TEST_ENTITY_ID_2 = 134;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var ProductAttributeValueRepositoryInterface
     */
    private $repository;

    /**
     * @var array
     */
    private $storeData = [
        [
            'store_id'   => self::TEST_STORE_ID_0,
            'code'       => 'admin',
            'website_id' => 0,
            'group_id'   => 0,
            'name'       => 'Admin store',
            'sort_order' => 1,
            'is_active'  => 1,
        ],
        [
            'store_id'   => self::TEST_STORE_ID_1,
            'code'       => 'default',
            'website_id' => 1,
            'group_id'   => 1,
            'name'       => 'Default store',
            'sort_order' => 1,
            'is_active'  => 1,
        ],
        [
            'store_id'   => self::TEST_STORE_ID_2,
            'code'       => 'second',
            'website_id' => 1,
            'group_id'   => 1,
            'name'       => 'Default store',
            'sort_order' => 1,
            'is_active'  => 1,
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
            'backend_model'   => 'catalog/product_attribute_backend_startdate_specialprice',
            'backend_type'    => 'datetime',
            'backend_table'   => null,
            'frontend_model'  => null,
            'frontend_input'  => 'date',
            'frontend_label'  => 'Special Price From Date',
            'frontend_class'  => null,
            'source_model'    => null,
            'is_required'     => 0,
            'is_user_defined' => 0,
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
    private $productEntityData = [
        [
            'entity_id'        => self::TEST_ENTITY_ID_1,
            'entity_type_id'   => self::TEST_ENTITY_TYPE_ID_1,
            'attribute_set_id' => self::TEST_ATTRIBUTE_SET_ID_1,
            'type_id'          => 'simple',
            'sku'              => 'PROD-000001.001',
            'has_options'      => 0,
            'required_options' => 0,
            'created_at'       => '2016-01-04 20:15:42',
            'updated_at'       => '2016-01-05 10:45:22',
        ],
        [
            'entity_id'        => self::TEST_ENTITY_ID_2,
            'entity_type_id'   => self::TEST_ENTITY_TYPE_ID_1,
            'attribute_set_id' => self::TEST_ATTRIBUTE_SET_ID_2,
            'type_id'          => 'simple',
            'sku'              => 'PROD-000002.001',
            'has_options'      => 0,
            'required_options' => 0,
            'created_at'       => '2016-01-04 20:15:42',
            'updated_at'       => '2016-01-05 10:45:22',
        ],
    ];

    /**
     * @var array
     */
    private $productAttributeValueData = [
        [
            'value_id'       => 124,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_1,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_1,
            'store_id'       => self::TEST_STORE_ID_0,
            'entity_id'      => self::TEST_ENTITY_ID_1,
            'value'          => '2016-02-23 12:22:43',
        ],
        [
            'value_id'       => 125,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_1,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_2,
            'store_id'       => self::TEST_STORE_ID_0,
            'entity_id'      => self::TEST_ENTITY_ID_1,
            'value'          => '2016-05-01 22:34:30',
        ],
        [
            'value_id'       => 126,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_2,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_1,
            'store_id'       => self::TEST_STORE_ID_0,
            'entity_id'      => self::TEST_ENTITY_ID_2,
            'value'          => '2016-03-12 10:54:32',
        ],
        [
            'value_id'       => 127,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_2,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_2,
            'store_id'       => self::TEST_STORE_ID_0,
            'entity_id'      => self::TEST_ENTITY_ID_2,
            'value'          => '2016-06-30 08:07:01',
        ],

        [
            'value_id'       => 224,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_1,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_1,
            'store_id'       => self::TEST_STORE_ID_1,
            'entity_id'      => self::TEST_ENTITY_ID_1,
            'value'          => '2016-02-23 12:22:43',
        ],
        [
            'value_id'       => 225,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_1,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_2,
            'store_id'       => self::TEST_STORE_ID_1,
            'entity_id'      => self::TEST_ENTITY_ID_1,
            'value'          => '2016-05-01 22:34:30',
        ],
        [
            'value_id'       => 226,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_2,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_1,
            'store_id'       => self::TEST_STORE_ID_1,
            'entity_id'      => self::TEST_ENTITY_ID_2,
            'value'          => '2016-03-12 10:54:32',
        ],
        [
            'value_id'       => 227,
            'entity_type_id' => self::TEST_ATTRIBUTE_SET_ID_2,
            'attribute_id'   => self::TEST_ATTRIBUTE_ID_2,
            'store_id'       => self::TEST_STORE_ID_1,
            'entity_id'      => self::TEST_ENTITY_ID_2,
            'value'          => '2016-06-30 08:07:01',
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
            $platform->getTruncateTableSQL('core_store')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('eav_attribute')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity')
        );

        $this->getConnection()->exec(
            $platform->getTruncateTableSQL('catalog_product_entity_datetime')
        );
        $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        parent::setUp();

        $currentSchema = $this->getConnection()->getSchemaManager()->createSchema();

        $this->schema = new Schema();

        $schemaBuilder = new DoctrineSchemaBuilder($this->schema);
        $schemaBuilder->ensureStoreTable();
        $schemaBuilder->ensureAttributeTable();
        $schemaBuilder->ensureCatalogProductEntityTable();
        $schemaBuilder->ensureCatalogProductAttributeValueTable('datetime', 'datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToStoreLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToAttributeLinks('datetime');
        $schemaBuilder->ensureCatalogProductAttributeValueToCatalogProductEntityLinks('datetime');

        $comparator = new \Doctrine\DBAL\Schema\Comparator();
        $schemaDiff = $comparator->compare($currentSchema, $this->schema);

        foreach ($schemaDiff->toSql($this->getConnection()->getDatabasePlatform()) as $sql) {
            $this->getConnection()->exec($sql);
        }

        $this->truncateTables();

        foreach ($this->storeData as $row) {
            $this->getConnection()->insert('core_store', $row);

            if ($row['store_id'] === 0) {
                $this->getConnection()->update('core_store', ['store_id' => 0], [
                    'store_id' => $this->getConnection()->lastInsertId()
                ]);
            }
        }

        foreach ($this->attributeData as $row) {
            $this->getConnection()->insert('eav_attribute', $row);
        }

        foreach ($this->productEntityData as $row) {
            $this->getConnection()->insert('catalog_product_entity', $row);
        }

        foreach ($this->productAttributeValueData as $row) {
            $this->getConnection()->insert('catalog_product_entity_datetime', $row);
        }

        $this->repository = new ProductAttributeValueRepository(
            $this->getConnection(),
            new ProductAttributeValueQueryBuilder(
                $this->getConnection(),
                ProductAttributeValueQueryBuilder::getDefaultTable('datetime'),
                ProductAttributeValueQueryBuilder::getDefaultVariantAxisTable(),
                ProductAttributeValueQueryBuilder::getDefaultFields()
            ),
            $this->getAttributeRepositoryMock(),
            $this->getAttributeValueFactoryMock()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeRepositoryInterface
     */
    private function getAttributeMock()
    {
        $mock = $this->getMock(AttributeInterface::class);

        $mock->method('getId')
            ->willReturn(self::TEST_ATTRIBUTE_ID_1)
        ;

        $mock->method('getCode')
            ->willReturn(self::TEST_ATTRIBUTE_CODE_1)
        ;

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeRepositoryInterface
     */
    private function getAttributeRepositoryMock()
    {
        $mock = $this->getMock(AttributeRepositoryInterface::class);

        $mock->method('findOneById')
            ->willReturn($this->getAttributeMock())
        ;

        $mock->method('findOneByCode')
            ->willReturn($this->getAttributeMock())
        ;

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AttributeValueFactoryInterface
     */
    private function getAttributeValueFactoryMock()
    {
        $mock = $this->getMock(AttributeValueFactoryInterface::class);

        $mock->method('buildNew')
            ->with($this->isInstanceOf(AttributeInterface::class), $this->isType('array'))
            ->willReturnCallback(function($attribute, $data){
                return ImmutableDatetimeAttributeValue::buildNewWith($attribute, 124, new \DateTimeImmutable(), null, 0);
            })
        ;

        return $mock;
    }

    protected function tearDown()
    {
        $this->truncateTables();

        parent::tearDown();

        $this->repository = null;
    }

    public function testFetchingOneByProductAndAttributeFromDefault()
    {
        /** @var ProductInterface $product */
        $product = $this->getMock(ProductInterface::class);
        $product
            ->method('getId')
            ->willReturn(self::TEST_ENTITY_ID_1)
        ;

        /** @var AttributeInterface $attribute */
        $attribute = $this->getMock(AttributeInterface::class);
        $attribute
            ->method('getId')
            ->willReturn(self::TEST_ATTRIBUTE_ID_1)
        ;

        /** @var DatetimeAttributeValueInterface $attributeValue */
        $attributeValue = $this->repository->findOneByProductAndAttributeFromDefault($product, $attribute);
        $this->assertInstanceOf(DatetimeAttributeValueInterface::class, $attributeValue);

        $this->assertInstanceOf(\DateTimeInterface::class, $attributeValue->getValue());
    }

    public function testFetchingOneByProductAndAttributeFromDefaultButNonExistent()
    {
        /** @var ProductInterface $product */
        $product = $this->getMock(ProductInterface::class);
        $product
            ->method('getId')
            ->willReturn(3456)
        ;

        /** @var AttributeInterface $attribute */
        $attribute = $this->getMock(AttributeInterface::class);
        $attribute
            ->method('getId')
            ->willReturn(self::TEST_ATTRIBUTE_ID_1)
        ;

        $this->assertNull($this->repository->findOneByProductAndAttributeFromDefault($product, $attribute));
    }
}