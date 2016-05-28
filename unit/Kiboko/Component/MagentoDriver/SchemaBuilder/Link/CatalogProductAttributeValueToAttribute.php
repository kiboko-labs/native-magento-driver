<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductAttributeValueToAttribute
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
            !$this->schema->hasTable('eav_attribute')
        ) {
            return;
        }

        $entityTable = $this->schema->getTable($tableName);
        $attributeTable = $this->schema->getTable('eav_attribute');

        $entityTable->addForeignKeyConstraint(
            $attributeTable,
            [
                'attribute_id',
            ],
            [
                'attribute_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );
    }
}
