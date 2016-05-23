<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

class CatalogAttributeExtensionToAttribute
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
        if (!$this->schema->hasTable('catalog_eav_attribute') ||
            !$this->schema->hasTable('eav_attribute')
        ) {
            return;
        }

        $catalogAttributeTable = $this->schema->getTable('catalog_eav_attribute');
        $attributeTable = $this->schema->getTable('eav_attribute');

        $catalogAttributeTable->addForeignKeyConstraint(
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
