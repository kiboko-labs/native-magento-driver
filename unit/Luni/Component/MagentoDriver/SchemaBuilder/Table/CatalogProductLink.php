<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductEntity
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
        $table = $this->schema->createTable('catalog_product_entity');

        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'autoincrement' => true, 'notnull' => false]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('type_id', 'string', ['length' => 32, 'default' => 'simple', 'notnull' => false]);
        $table->addColumn('sku', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('has_options', 'smallint', ['unsigned' => true, 'default' => 0, 'notnull' => false]);
        $table->addColumn('required_options', 'smallint', ['unsigned' => true, 'default' => 0, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['columnDefinition' => 'DATETIME NULL DEFAULT NULL']);
        $table->addColumn('updated_at', 'datetime', ['columnDefinition' => 'DATETIME NULL DEFAULT NULL']);
        $table->setPrimaryKey(['entity_id']);
        $table->addIndex(['attribute_set_id']);
        $table->addIndex(['sku']);

        return $table;
    }
}
