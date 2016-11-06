<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogCategoryAttributeValue
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var string
     */
    private $backendType;

    /**
     * @var string
     */
    private $backendName;

    /**
     * @var array
     */
    private $backendOptions;

    /**
     * SchemaBuilder constructor.
     *
     * @param Schema $schema
     * @param string $backendType
     * @param string $backendName
     * @param array  $backendOptions
     */
    public function __construct(Schema $schema, $backendType, $backendName, array $backendOptions = [])
    {
        $this->schema = $schema;
        $this->backendType = $backendType;
        $this->backendName = $backendName;
        $this->backendOptions = $backendOptions;
    }

    /**
     * @param string $magentoVersion
     *
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function build($magentoVersion)
    {
        $table = $this->schema->createTable(sprintf('catalog_category_entity_%s', $this->backendName));

        $table->addColumn('value_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('entity_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('value', $this->backendType, $this->backendOptions);

        $table->setPrimaryKey(['value_id']);
        $table->addUniqueIndex(['entity_type_id', 'entity_id', 'attribute_id', 'store_id']);
        $table->addIndex(['entity_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
