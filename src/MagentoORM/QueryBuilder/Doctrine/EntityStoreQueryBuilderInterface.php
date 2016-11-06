<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface EntityStoreQueryBuilderInterface
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
    public function createFindOneByTypeIdQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByStoreIdQueryBuilder($alias);

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList);

    /**
     * @param string      $alias
     * @param array|int[] $storeIdList
     *
     * @return QueryBuilder
     */
    public function createFindAllByStoreIdQueryBuilder($alias, array $storeIdList);

    /**
     * @param string      $alias
     * @param array|int[] $typeIdList
     *
     * @return QueryBuilder
     */
    public function createFindAllByTypeIdQueryBuilder($alias, array $typeIdList);

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
