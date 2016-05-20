<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogCategoryProduct
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
        $table = $this->schema->createTable('catalog_category_product');

        $table->addColumn('category_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('product_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('position', 'integer', ['default' => 0]);

        $table->setPrimaryKey(['category_id', 'product_id']);
        $table->addIndex(['product_id']);

        return $table;
    }
}
