<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class AttributeGroup
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
        $table = $this->schema->createTable('eav_attribute_group');

        $table->addColumn('attribute_group_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('attribute_set_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_group_name', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('sort_order', 'smallint', ['default' => 0]);
        $table->addColumn('default_id', 'smallint', ['unsigned' => true, 'notnull' => false, 'default' => 0]);

        if (version_compare($magentoVersion, '2.0', '>=')) {
            $table->addColumn('attribute_group_code', 'string', ['length' => 255]);
            $table->addColumn('tab_group_code', 'string', ['length' => 255, 'notnull' => false]);
        }

        $table->setPrimaryKey(['attribute_group_id']);
        $table->addUniqueIndex(['attribute_set_id', 'attribute_group_name']);
        $table->addIndex(['attribute_set_id', 'sort_order']);

        return $table;
    }
}
