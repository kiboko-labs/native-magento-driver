<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogCategoryProductIndex
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
    public function build($magentoVersion = null)
    {
        $table = $this->schema->createTable('catalog_category_product_index');

        $table->addColumn('category_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('product_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('position', 'integer', ['notnull' => false]);
        $table->addColumn('is_parent', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('visibility', 'smallint', ['unsigned' => true]);
        
        $table->setPrimaryKey(['category_id', 'product_id', 'store_id']);
        $table->addIndex(['product_id', 'store_id', 'category_id', 'visibility']);
        $table->addIndex(['store_id', 'category_id', 'visibility', 'is_parent', 'position']);

        return $table;
    }
}
