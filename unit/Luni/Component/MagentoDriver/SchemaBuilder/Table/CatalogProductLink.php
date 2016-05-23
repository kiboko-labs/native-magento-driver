<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductLink
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
        $table = $this->schema->createTable('catalog_product_link');

        $table->addColumn('link_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('product_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('linked_product_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('link_type_id', 'smallint', ['default' => '0']);

        $table->setPrimaryKey(['link_id']);
        $table->addUniqueIndex(['link_type_id', 'product_id', 'linked_product_id']);
        $table->addIndex(['product_id']);
        $table->addIndex(['linked_product_id']);
        $table->addIndex(['link_type_id']);

        return $table;
    }
}
