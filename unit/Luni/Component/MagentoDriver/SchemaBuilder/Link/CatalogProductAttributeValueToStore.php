<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

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
    public function build($magentoVersion = null)
    {
        $tableName = sprintf('catalog_product_entity_%s', $this->backendName);
        if (!$this->schema->hasTable($tableName) ||
            !$this->schema->hasTable('core_store')
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $storeTable = $this->schema->getTable('core_store');

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
