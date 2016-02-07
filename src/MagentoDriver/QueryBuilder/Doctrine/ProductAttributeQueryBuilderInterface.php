<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductAttributeQueryBuilderInterface
    extends AttributeQueryBuilderInterface
{
    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $variantAxisAlias
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByEntityQueryBuilder($alias, $extraAlias, $entityAlias, $variantAxisAlias);

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $extraAlias, $entityAlias, $familyAlias);

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllMandatoryByFamilyQueryBuilder($alias, $extraAlias, $entityAlias, $familyAlias);
}