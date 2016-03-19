<?php

namespace unit\Luni\Component\MagentoDriver\SchemaBuilder\Link;

use Doctrine\DBAL\Schema\Schema;

class FamilyToEntityType
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * SchemaBuilder constructor.
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @param string $magentoVersion
     * @return \Doctrine\DBAL\Schema\Table
     */
    public function build($magentoVersion = null)
    {
        if (!$this->schema->hasTable('eav_attribute_set') ||
            !$this->schema->hasTable('eav_entity_type')
        ) {
            return;
        }

        $familyTable = $this->schema->getTable('eav_attribute_set');
        $entityTypeTable = $this->schema->getTable('eav_entity_type');

        $familyTable->addForeignKeyConstraint(
            $entityTypeTable,
            [
                'entity_type_id'
            ],
            [
                'entity_type_id'
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE'
            ]
        );
    }
}