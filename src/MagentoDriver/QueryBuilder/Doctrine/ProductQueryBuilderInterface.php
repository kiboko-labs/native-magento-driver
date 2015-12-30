<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductQueryBuilderInterface
{
    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdentifierQueryBuilder($alias);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string $alias
     * @param array|string[] $identifierList
     * @return QueryBuilder
     */
    public function createFindAllByIdentifierQueryBuilder($alias, array $identifierList);

    /**
     * @param string $alias
     * @param array|int[] $idList
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList);

    /**
     * @param string $alias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $familyAlias);

    /**
     * @param string $alias
     * @param string $categoryAlias
     * @return QueryBuilder
     */
    public function createFindAllByCategoryQueryBuilder($alias, $categoryAlias);
}