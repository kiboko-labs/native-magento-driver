<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogAttributeExtension
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * SchemaBuilder constructor.
     *
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @param string $magentoVersion
     *
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function build($magentoVersion)
    {
        $table = $this->schema->createTable('catalog_eav_attribute');

        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('frontend_input_renderer', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_global', 'smallint', ['unsigned' => true, 'default' => 1]);
        $table->addColumn('is_visible', 'smallint', ['unsigned' => true, 'default' => 1]);
        $table->addColumn('is_searchable', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_filterable', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_comparable', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_visible_on_front', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_html_allowed_on_front', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_used_for_price_rules', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_filterable_in_search', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('used_in_product_listing', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('used_for_sort_by', 'smallint', ['unsigned' => true, 'default' => 0]);

        if (version_compare($magentoVersion, '2.0', '<')) {
            $table->addColumn('is_configurable', 'smallint', ['unsigned' => true, 'default' => 1]);
        }

        $table->addColumn('apply_to', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_visible_in_advanced_search', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('position', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_wysiwyg_enabled', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_used_for_promo_rules', 'smallint', ['unsigned' => true, 'default' => 0]);

        if (version_compare($magentoVersion, '2.0', '>=')) {
            $table->addColumn('is_required_in_admin_store', 'smallint', ['unsigned' => true, 'default' => 0]);
            $table->addColumn('is_used_in_grid', 'smallint', ['unsigned' => true, 'default' => 0]);
            $table->addColumn('is_visible_in_grid', 'smallint', ['unsigned' => true, 'default' => 0]);
            $table->addColumn('is_filterable_in_grid', 'smallint', ['unsigned' => true, 'default' => 0]);
            $table->addColumn('search_weight', 'float', ['default' => 1]);
            $table->addColumn('additional_data', 'text', ['notnull' => false]);
        }

        $table->setPrimaryKey(['attribute_id']);
        $table->addIndex(['used_for_sort_by']);
        $table->addIndex(['used_in_product_listing']);

        return $table;
    }
}
