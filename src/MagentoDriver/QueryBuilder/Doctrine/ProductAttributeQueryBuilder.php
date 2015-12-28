<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\QueryBuilder;

class ProductAttributeQueryBuilder
    implements ProductAttributeQueryBuilderInterface
{
    use AttributeQueryBuilderTrait;

    /**
     * @var string
     */
    private $variantAxisTable;

    /**
     * @var string
     */
    private $familyTable;

    /**
     * @param Connection $connection
     * @param string $table
     * @param string $extraTable
     * @param string $variantAxisTable
     * @param string $familyTable
     * @param array $fields
     * @param array $extraFields
     */
    public function __construct(
        Connection $connection,
        $table,
        $extraTable,
        $variantAxisTable,
        $familyTable,
        array $fields,
        array $extraFields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->extraTable = $extraTable;
        $this->variantAxisTable = $variantAxisTable;
        $this->familyTable = $familyTable;

        $this->fields = $fields;
        $this->extraFields = $extraFields;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $variantAxisAlias
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByEntityQueryBuilder($alias, $extraAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->innerJoin($alias, $this->variantAxisTable, $variantAxisAlias,
                sprintf('%s.attribute_id=%s.attribute_id', $variantAxisAlias, $alias))
            ->where(sprintf('%s.product_id = ?', $variantAxisAlias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $extraAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->innerJoin($alias, $this->familyTable, $familyAlias,
                sprintf('%1$s.entity_type_id=%2$s.entity_type_id', $familyAlias, $alias))
            ->where(sprintf('%s.attribute_set_id = ?', $familyAlias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllMandatoryByFamilyQueryBuilder($alias, $extraAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->innerJoin($alias, $this->familyTable, $familyAlias,
                sprintf('%1$s.entity_type_id=%2$s.entity_type_id', $familyAlias, $alias))
            ->where(sprintf('%s.attribute_set_id = ?', $familyAlias))
            ->andWhere(sprintf('%s.is_required = 1', $alias))
        ;

        return $queryBuilder;
    }
}