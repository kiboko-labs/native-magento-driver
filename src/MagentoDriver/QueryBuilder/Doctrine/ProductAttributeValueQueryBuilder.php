<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

class ProductAttributeValueQueryBuilder
    implements ProductAttributeValueQueryBuilderInterface
{
    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'value_id',
            'entity_type_id',
            'attribute_id',
            'store_id',
            'entity_id',
            'value',
        ];
    }

    /**
     * @param $backend
     * @param null $prefix
     * @return string
     */
    public static function getDefaultTable($backend, $prefix = null)
    {
        return sprintf('%scatalog_product_entity_%s', $prefix, $backend);
    }
}