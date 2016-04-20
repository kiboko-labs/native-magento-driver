<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class AttributeOptionValue
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
        $table = $this->schema->createTable('eav_attribute_option_value');
        
        $table->addColumn('value_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('option_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('value', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['value_id']);
        $table->addIndex(['option_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
