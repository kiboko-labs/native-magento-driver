<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductAttributeQueryBuilderInterface
    extends AttributeQueryBuilderInterface
{
    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $variantAxisAlias
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByEntityQueryBuilder($alias, $extraAlias, $variantAxisAlias);

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $extraAlias, $familyAlias);

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllMandatoryByFamilyQueryBuilder($alias, $extraAlias, $familyAlias);
}