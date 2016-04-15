<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface EntityTypeQueryBuilderInterface
{
    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias);

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList);

    /**
     * @param string      $alias
     * @param array|int[] $codeList
     *
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilder($alias, array $codeList);

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder();

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder();

    /**
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList);
}
