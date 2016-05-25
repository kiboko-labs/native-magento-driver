<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductAttributeValue
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
    public function build($magentoVersion = null)
    {
        $table = $this->schema->createTable(sprintf('catalog_product_entity_%s', $this->backendName));

        $table->addColumn('value_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('entity_type_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('attribute_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('store_id', 'smallint', ['unsigned' => true]);
        $table->addColumn('entity_id', 'integer', ['unsigned' => true]);
        $table->addColumn('value', $this->backendType, $this->backendOptions);

        $table->setPrimaryKey(['value_id']);
        $table->addUniqueIndex(['attribute_id', 'store_id', 'entity_id']);
        $table->addIndex(['attribute_id']);
        $table->addIndex(['store_id']);

        return $table;
    }
}
