<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductMediaGalleryAttributeValue
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
        $table = $this->schema->createTable('catalog_product_entity_media_gallery_value');

        $table->addColumn('value_id', 'integer', ['autoincrement' => true, 'unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('label', 'string', ['length' => 255, 'notnul' => false]);
        $table->addColumn('position', 'integer', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('disabled', 'smallint', ['unsigned' => true, 'default' => 0]);

        $table->setPrimaryKey(['value_id', 'store_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
