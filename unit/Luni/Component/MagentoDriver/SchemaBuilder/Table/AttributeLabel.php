<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class AttributeLabel
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
        $table = $this->schema->createTable('eav_attribute_label');

        $table->addColumn('attribute_label_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('value', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['attribute_label_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['store_id']);
        $table->addIndex(['attribute_id', 'store_id']);

        return $table;
    }
}
