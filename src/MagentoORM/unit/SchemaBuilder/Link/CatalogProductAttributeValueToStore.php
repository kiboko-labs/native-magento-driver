<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;
use unit\Kiboko\Component\MagentoORM\SchemaBuilder\Table\Store as StoreTableSchemaBuilder;

class CatalogProductAttributeValueToStore
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * @var string
     */
    private $backendName;

    /**
     * SchemaBuilder constructor.
     *
     * @param Schema $schema
     * @param string $backendName
     */
    public function __construct(Schema $schema, $backendName)
    {
        $this->schema = $schema;
        $this->backendName = $backendName;
    }

    /**
     * @param string $magentoVersion
     *
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function build($magentoVersion)
    {
        $tableName = sprintf('catalog_product_entity_%s', $this->backendName);
        if (!$this->schema->hasTable($tableName) ||
            !$this->schema->hasTable(StoreTableSchemaBuilder::getTableName($magentoVersion))
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $storeTable = $this->schema->getTable(StoreTableSchemaBuilder::getTableName($magentoVersion));

        $entityTable->addForeignKeyConstraint(
            $storeTable,
            [
                'store_id',
            ],
            [
                'store_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );
    }
}
