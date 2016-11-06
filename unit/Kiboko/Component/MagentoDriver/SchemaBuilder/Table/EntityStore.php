<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class EntityStore
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
        $table = $this->schema->createTable('eav_entity_store');

        $table->addColumn('entity_store_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('increment_prefix', 'string', ['length' => 20, 'notnull' => false]);
        $table->addColumn('increment_last_id', 'string', ['length' => 50, 'notnull' => false]);

        $table->setPrimaryKey(['entity_store_id']);
        $table->addIndex(['entity_type_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
