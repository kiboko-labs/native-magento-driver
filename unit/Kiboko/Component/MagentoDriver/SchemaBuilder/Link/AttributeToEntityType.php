<?php

namespace unit\Kiboko\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

class AttributeToEntityType
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
        if (!$this->schema->hasTable('eav_attribute') ||
            !$this->schema->hasTable('eav_entity_type')
        ) {
            return;
        }

        $attributeTable = $this->schema->getTable('eav_attribute');
        $entityTypeTable = $this->schema->getTable('eav_entity_type');

        $attributeTable->addForeignKeyConstraint(
            $entityTypeTable,
            [
                'entity_type_id',
            ],
            [
                'entity_type_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );
    }
}
