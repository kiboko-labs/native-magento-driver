<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductMediaGallery
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
        $table = $this->schema->createTable('catalog_product_entity_media_gallery');

        $table->addColumn('value_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('value', 'string', ['length' => 255]);

        $table->setPrimaryKey(['value_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['entity_id']);

        return $table;
    }
}
