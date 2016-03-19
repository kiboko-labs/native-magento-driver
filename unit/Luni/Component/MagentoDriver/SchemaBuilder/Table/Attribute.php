<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class Attribute
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * SchemaBuilder constructor.
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @param string $magentoVersion
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function build($magentoVersion = null)
    {
        $table = $this->schema->createTable('eav_attribute');

        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_code', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('attribute_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('backend_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('backend_type', 'string', ['length' => 8, 'default' => 'static']);
        $table->addColumn('backend_table', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_input', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_label', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('frontend_class', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('source_model', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('is_required', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('is_user_defined', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('default_value', 'string', ['length' => 65536, 'notnull' => false]);
        $table->addColumn('is_unique', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('note', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['attribute_id']);
        $table->addUniqueIndex(['entity_type_id', 'attribute_code']);
        $table->addIndex(['entity_type_id']);

        return $table;
    }
}