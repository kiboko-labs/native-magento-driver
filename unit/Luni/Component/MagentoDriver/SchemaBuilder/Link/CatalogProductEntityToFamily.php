<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

class CatalogProductEntityToFamily
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
        if (!$this->schema->hasTable('catalog_product_entity') ||
            !$this->schema->hasTable('eav_attribute_set')
        ) {
            return;
        }

        $catalogAttributeTable = $this->schema->getTable('catalog_product_entity');
        $attributeTable = $this->schema->getTable('eav_attribute_set');

        $catalogAttributeTable->addForeignKeyConstraint(
            $attributeTable,
            [
                'attribute_set_id',
            ],
            [
                'attribute_set_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );
    }
}
