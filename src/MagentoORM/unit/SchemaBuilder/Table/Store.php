<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class Store
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
        $table = $this->schema->createTable($this->getTableName($magentoVersion));

        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('code', 'string', ['length' => 32]);
        $table->addColumn('website_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('group_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('sort_order', 'smallint', ['unsigned' => true]);
        $table->addColumn('is_active', 'smallint', ['unsigned' => true]);

        $table->setPrimaryKey(['store_id']);
        $table->addUniqueIndex(['code']);
        $table->addIndex(['website_id']);
        $table->addIndex(['is_active', 'sort_order']);
        $table->addIndex(['group_id']);

        return $table;
    }
    
    /**
     * @param string $magentoVersion
     * @return string
     */
    public static function getTableName($magentoVersion)
    {
        if (version_compare($magentoVersion, '2.0', '<')) {
            return 'core_store';
        }

        return 'store';
    }
}
