<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class AttributeOption
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
        $table = $this->schema->createTable('eav_attribute_option');

        $table->addColumn('option_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('sort_order', 'smallint', ['unsigned' => true, 'default' => 0]);

        $table->setPrimaryKey(['option_id']);
        $table->addIndex(['attribute_id']);

        return $table;
    }
}
