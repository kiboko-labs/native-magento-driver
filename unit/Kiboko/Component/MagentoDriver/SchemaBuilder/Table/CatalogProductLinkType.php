<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductLinkType
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
        $table = $this->schema->createTable('catalog_product_link_type');

        $table->addColumn('link_type_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('code', 'string', ['length' => 32, 'notnull' => false]);

        $table->setPrimaryKey(['link_type_id']);

        return $table;
    }
}
