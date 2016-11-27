<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class AttributeQueryBuilder implements AttributeQueryBuilderInterface
{
    use AttributeQueryBuilderTrait;

    /**
     * @param Connection $connection
     * @param string     $table
     * @param string     $entityTable
     * @param array      $fields
     */
    public function __construct(
        Connection $connection,
        $table,
        $entityTable,
        array $fields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->entityTable = $entityTable;

        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'attribute_id',
            'entity_type_id',
            'attribute_code',
            'attribute_model',
            'backend_model',
            'backend_type',
            'backend_table',
            'frontend_model',
            'frontend_input',
            'frontend_label',
            'frontend_class',
            'source_model',
            'is_required',
            'is_user_defined',
            'default_value',
            'is_unique',
            'note',
        ];
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute', $prefix);
        }

        return 'eav_attribute';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultEntityTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_entity_type', $prefix);
        }

        return 'eav_entity_type';
    }
}
