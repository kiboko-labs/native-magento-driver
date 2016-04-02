<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class Family
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
        $table = $this->schema->createTable('eav_attribute_set');

        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_set_name', 'string', ['length' => 255]);
        $table->addColumn('sort_order', 'smallint', ['unsigned' => true]);

        $table->setPrimaryKey(['attribute_set_id']);
        $table->addUniqueIndex(['entity_type_id', 'attribute_set_name']);
        $table->addIndex(['entity_type_id', 'sort_order']);

        return $table;
    }
}
