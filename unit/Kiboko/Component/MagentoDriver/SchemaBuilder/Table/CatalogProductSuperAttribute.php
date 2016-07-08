<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductSuperAttribute
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
        $table = $this->schema->createTable('catalog_product_super_attribute');

        $table->addColumn('product_super_attribute_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('product_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('position', 'smallint', ['unsigned' => true, 'default' => 0]);

        $table->setPrimaryKey(['product_super_attribute_id']);
        $table->addUniqueIndex(['product_id', 'attribute_id']);
        $table->addIndex(['product_id']);

        return $table;
    }
}
