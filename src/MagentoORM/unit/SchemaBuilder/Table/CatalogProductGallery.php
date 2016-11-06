<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductGallery
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
        $table = $this->schema->createTable('catalog_product_entity_gallery');

        $table->addColumn('value_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('position', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('value', 'string', ['length' => 255]);

        $table->setPrimaryKey(['value_id']);
        $table->addUniqueIndex(['entity_type_id', 'entity_id', 'attribute_id', 'store_id']);

        $table->addIndex(['entity_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
