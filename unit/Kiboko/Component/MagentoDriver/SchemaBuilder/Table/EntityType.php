<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class EntityType
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
        $table = $this->schema->createTable('eav_entity_type');

        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_code', 'string', ['length' => 50]);
        $table->addColumn('entity_model', 'string', ['length' => 255]);
        $table->addColumn('attribute_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('value_table_prefix', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_id_field', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_data_sharing', 'smallint', ['unsigned' => true]);
        $table->addColumn('data_sharing_key', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('default_attribute_set_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('increment_per_store', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_pad_length', 'smallint', ['unsigned' => true]);
        $table->addColumn('increment_pad_char', 'string', ['length' => 1]);
        $table->addColumn('additional_attribute_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('entity_attribute_collection', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['entity_type_id']);
        $table->addIndex(['entity_type_code']);

        return $table;
    }
}
