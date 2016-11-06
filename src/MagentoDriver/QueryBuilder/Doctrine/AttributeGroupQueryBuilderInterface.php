<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface AttributeGroupQueryBuilderInterface
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
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByNameQueryBuilder($alias);

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList);

    /**
     * @param string         $alias
     * @param array|string[] $nameList
     *
     * @return QueryBuilder
     */
    public function createFindAllByNameQueryBuilder($alias, array $nameList);

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

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByNameQueryBuilder();

    /**
     * @param array|string[] $nameList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByNameQueryBuilder(array $nameList);
}
