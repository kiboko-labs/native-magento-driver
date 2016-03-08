<?php

namespace unit\Luni\Component\MagentoDriver;

use Doctrine\DBAL\Schema\Schema;

class DoctrineSchemaBuilder
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * SchemaBuilder constructor.
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureStoreTable()
    {
        $table = $this->schema->createTable('core_store');

        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('code', 'string', ['length' => 32]);
        $table->addColumn('website_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('group_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('sort_order', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_active', 'smallint', ['unsigned' => true]);

        $table->setPrimaryKey(['store_id']);
        $table->addUniqueIndex(['code']);
        $table->addIndex(['website_id']);
        $table->addIndex(['is_active', 'sort_order']);
        $table->addIndex(['group_id']);

        return $table;
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureEntityTypeTable()
    {
        $table = $this->schema->createTable('eav_entity_type');

        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_code', 'string', ['length' => 50]);
        $table->addColumn('entity_model', 'string', ['length' => 255]);
        $table->addColumn('attribute_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('value_table_prefix', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_id_field', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_data_sharing', 'smallint', ['unsigned' => true]);
        $table->addColumn('data_sharing_key', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('default_attribute_set_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('increment_per_store', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_pad_length', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_pad_char', 'string', ['length' => 1]);
        $table->addColumn('additional_attribute_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_attribute_collection', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['entity_type_id']);
        $table->addIndex(['entity_type_code']);

        return $table;
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureFamilyTable()
    {
        $table = $this->schema->createTable('eav_attribute_set');

        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_set_name', 'string', ['length' => 255]);
        $table->addColumn('sort_order', 'smallint', ['unsigned' => true]);

        $table->setPrimaryKey(['attribute_set_id']);
        $table->addUniqueIndex(['entity_type_id', 'attribute_set_name']);
        $table->addIndex(['entity_type_id', 'sort_order']);

        return $table;
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureFamilyToEntityTypeLinks()
    {
        if (!$this->schema->hasTable('eav_attribute_set') ||
            !$this->schema->hasTable('eav_entity_type')
        ) {
            return;
        }

        $familyTable = $this->schema->getTable('eav_attribute_set');
        $entityTypeTable = $this->schema->getTable('eav_entity_type');

        $familyTable->addForeignKeyConstraint(
            $entityTypeTable,
            [
                'entity_type_id'
            ],
            [
                'entity_type_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureAttributeTable()
    {
        $table = $this->schema->createTable('eav_attribute');

        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_code', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('attribute_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('backend_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('backend_type', 'string', ['length' => 8, 'default' => 'static']);
        $table->addColumn('backend_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_input', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_label', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_class', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('source_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_required', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_user_defined', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('default_value', 'string', ['length' => 65536, 'notnull' => false]);
        $table->addColumn('is_unique', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('note', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['attribute_id']);
        $table->addUniqueIndex(['entity_type_id', 'attribute_code']);
        $table->addIndex(['entity_type_id']);

        return $table;
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureAttributeToEntityTypeLinks()
    {
        if (!$this->schema->hasTable('eav_attribute') ||
            !$this->schema->hasTable('eav_entity_type')
        ) {
            return;
        }

        $attributeTable = $this->schema->getTable('eav_attribute');
        $entityTypeTable = $this->schema->getTable('eav_entity_type');

        $attributeTable->addForeignKeyConstraint(
            $entityTypeTable,
            [
                'entity_type_id'
            ],
            [
                'entity_type_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureCatalogAttributeExtraTable()
    {
        $table = $this->schema->createTable('catalog_eav_attribute');

        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('frontend_input_renderer', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_global', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_visible', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_searchable', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_filterable', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_comparable', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_visible_on_front', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_html_allowed_on_front', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_used_for_price_rules', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_filterable_in_search', 'smallint', ['unsigned' => true]);
        $table->addColumn('used_in_product_listing', 'smallint', ['unsigned' => true]);
        $table->addColumn('used_for_sort_by', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_configurable', 'smallint', ['unsigned' => true]);
        $table->addColumn('apply_to', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_visible_in_advanced_search', 'smallint', ['unsigned' => true]);
        $table->addColumn('position', 'integer', ['unsigned' => true]);
        $table->addColumn('is_wysiwyg_enabled', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_used_for_promo_rules', 'smallint', ['unsigned' => true]);

        $table->setPrimaryKey(['attribute_id']);
        $table->addIndex(['used_for_sort_by']);
        $table->addIndex(['used_in_product_listing']);

        return $table;
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogAttributeExtraToAttributeLinks()
    {
        if (!$this->schema->hasTable('catalog_eav_attribute') ||
            !$this->schema->hasTable('eav_attribute')
        ) {
            return;
        }

        $catalogAttributeTable = $this->schema->getTable('catalog_eav_attribute');
        $attributeTable = $this->schema->getTable('eav_attribute');

        $catalogAttributeTable->addForeignKeyConstraint(
            $attributeTable,
            [
                'attribute_id'
            ],
            [
                'attribute_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureCatalogProductEntityTable()
    {
        $table = $this->schema->createTable('catalog_product_entity');

        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'autoincrement' => true, 'notnull' => false]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('type_id', 'string', ['length' => 32, 'default' => 'simple', 'notnull' => false]);
        $table->addColumn('sku', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('has_options', 'smallint', ['unsigned' => true, 'default' => 0, 'notnull' => false]);
        $table->addColumn('required_options', 'smallint', ['unsigned' => true, 'default' => 0, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['columnDefinition' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['columnDefinition' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['entity_id']);
        $table->addIndex(['attribute_set_id']);
        $table->addIndex(['sku']);

        return $table;
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function ensureCatalogProductEntityToFamilyLinks()
    {
        if (!$this->schema->hasTable('catalog_product_entity') ||
            !$this->schema->hasTable('eav_attribute_set')
        ) {
            return;
        }

        $catalogAttributeTable = $this->schema->getTable('catalog_product_entity');
        $attributeTable = $this->schema->getTable('eav_attribute_set');

        $catalogAttributeTable->addForeignKeyConstraint(
            $attributeTable,
            [
                'attribute_set_id'
            ],
            [
                'attribute_set_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    /**
     * @param string $backendName
     * @param string $backendType
     * @param array $backendOptions
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function ensureCatalogProductAttributeValueTable($backendName, $backendType, array $backendOptions = [])
    {
        $table = $this->schema->createTable(sprintf('catalog_product_entity_%s', $backendName));

        $table->addColumn('value_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('entity_id', 'integer', ['unsigned' => true]);
        $table->addColumn('value', $backendType, $backendOptions);

        $table->setPrimaryKey(['value_id']);
        $table->addUniqueIndex(['attribute_id', 'store_id', 'entity_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['store_id']);

        return $table;
    }

    public function ensureCatalogProductAttributeValueToAttributeLinks($backendName)
    {
        $tableName = sprintf('catalog_product_entity_%s', $backendName);
        if (!$this->schema->hasTable($tableName) ||
            !$this->schema->hasTable('eav_attribute')
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $attributeTable = $this->schema->getTable('eav_attribute');

        $entityTable->addForeignKeyConstraint(
            $attributeTable,
            [
                'attribute_id'
            ],
            [
                'attribute_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    public function ensureCatalogProductAttributeValueToStoreLinks($backendName)
    {
        $tableName = sprintf('catalog_product_entity_%s', $backendName);
        if (!$this->schema->hasTable($tableName) ||
            !$this->schema->hasTable('core_store')
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $storeTable = $this->schema->getTable('core_store');

        $entityTable->addForeignKeyConstraint(
            $storeTable,
            [
                'store_id'
            ],
            [
                'store_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }

    public function ensureCatalogProductAttributeValueToCatalogProductEntityLinks($backendName)
    {
        $tableName = sprintf('catalog_product_entity_%s', $backendName);
        if (!$this->schema->hasTable($tableName) ||
            !$this->schema->hasTable('catalog_product_entity')
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $storeTable = $this->schema->getTable('catalog_product_entity');

        $entityTable->addForeignKeyConstraint(
            $storeTable,
            [
                'entity_id'
            ],
            [
                'entity_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }
}