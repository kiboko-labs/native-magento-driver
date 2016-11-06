<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductLinkAttribute
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
        $table = $this->schema->createTable('catalog_product_link_attribute');

        $table->addColumn('product_link_attribute_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('link_type_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('product_link_attribute_code', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('data_type', 'string', ['length' => 32, 'notnull' => false]);

        $table->setPrimaryKey(['product_link_attribute_id']);
        $table->addIndex(['link_type_id']);

        return $table;
    }
}
