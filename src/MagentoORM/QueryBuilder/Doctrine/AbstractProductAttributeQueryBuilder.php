<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;

abstract class AbstractProductAttributeQueryBuilder implements ProductAttributeQueryBuilderInterface
{
    use AndWhereDoctrineFixForPHP7;
    use CatalogAttributeQueryBuilderTrait;

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
     * @param string     $table
     * @param string     $extraTable
     * @param string     $entityTable
     * @param string     $variantAxisTable
     * @param string     $familyTable
     * @param array      $fields
     * @param array      $extraFields
     */
    public function __construct(
        Connection $connection,
        $table,
        $extraTable,
        $entityTable,
        $variantAxisTable,
        $familyTable,
        array $fields,
        array $extraFields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->extraTable = $extraTable;
        $this->variantAxisTable = $variantAxisTable;
        $this->entityTable = $entityTable;
        $this->familyTable = $familyTable;

        $this->fields = $fields;
        $this->extraFields = $extraFields;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByEntityQueryBuilderWithExtra($alias, $extraAlias, $entityAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias);

        $queryBuilder->innerJoin($alias, $this->variantAxisTable, $variantAxisAlias,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $variantAxisAlias), sprintf('%s.attribute_id', $alias))
        );

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.product_id', $variantAxisAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilderWithExtra($alias, $extraAlias, $entityAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias);

        $queryBuilder->innerJoin($alias, $this->familyTable, $familyAlias,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $familyAlias), sprintf('%s.entity_type_id', $alias))
        );

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $familyAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllMandatoryByFamilyQueryBuilderWithExtra($alias, $extraAlias, $entityAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias);
        $queryBuilder->innerJoin($alias, $this->familyTable, $familyAlias,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $familyAlias), sprintf('%s.entity_type_id', $alias))
        );

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $familyAlias), '?'),
            $queryBuilder->expr()->eq(sprintf('%s.is_required', $alias), $queryBuilder->expr()->literal(1))
        );

        return $queryBuilder;
    }
}
