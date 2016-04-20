<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class EntityAttribute
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
        $table = $this->schema->createTable('eav_entity_attribute');
        
        $table->addColumn('entity_attribute_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_group_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('sort_order', 'smallint', ['default' => 0]);

        $table->setPrimaryKey(['entity_attribute_id']);
        $table->addUniqueIndex(['attribute_set_id', 'attribute_id']);
        $table->addUniqueIndex(['attribute_group_id', 'attribute_id']);
        $table->addIndex(['attribute_set_id', 'sort_order']);
        $table->addIndex(['attribute_id']);

        return $table;
    }
}
