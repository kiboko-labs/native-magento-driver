<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogCategoryEntity
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
        $table = $this->schema->createTable('catalog_category_entity');

        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'autoincrement' => true, 'notnull' => false]);
        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'notnull' => false, 'default' => 0]);
        $table->addColumn('parent_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('created_at', 'datetime', ['columnDefinition' => 'DATETIME NULL DEFAULT NULL']);
        $table->addColumn('updated_at', 'datetime', ['columnDefinition' => 'DATETIME NULL DEFAULT NULL']);
        $table->addColumn('path', 'string', ['length' => 255]);
        $table->addColumn('position', 'integer', []);
        $table->addColumn('level', 'integer', ['default' => 0]);
        $table->addColumn('children_count', 'integer', []);

        $table->setPrimaryKey(['entity_id']);
        $table->addIndex(['level']);
        $table->addIndex(['path', 'entity_id']);

        return $table;
    }
}
