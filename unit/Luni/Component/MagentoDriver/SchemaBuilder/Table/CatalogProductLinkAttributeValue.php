<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Table;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductLinkAttributeValue
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
        $table = $this->schema->createTable(sprintf('catalog_product_link_attribute_%s', $this->backendName));

        $table->addColumn('value_id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('product_link_attribute_id', 'smallint', ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('link_id', 'integer', ['unsigned' => true]);
        $table->addColumn('value', $this->backendType, $this->backendOptions);

        $table->setPrimaryKey(['value_id']);
        $table->addUniqueIndex(['product_link_attribute_id', 'link_id']);
        $table->addIndex(['product_link_attribute_id']);
        $table->addIndex(['link_id']);

        return $table;
    }
}
