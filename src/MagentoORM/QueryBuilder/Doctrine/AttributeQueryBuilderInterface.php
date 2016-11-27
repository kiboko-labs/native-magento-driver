<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface AttributeQueryBuilderInterface
{
    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindQueryBuilder($alias);

    /**
     * @param string $alias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias, array $excludedIds = []);

    /**
     * @param string $alias
     * @param string $entityAlias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllByEntityTypeQueryBuilder($alias, $entityAlias, array $excludedIds = []);

    /**
     * @param string $alias
     * @param string $entityAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias, $entityAlias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string         $alias
     * @param string         $entityAlias
     * @param array|string[] $codeList
     *
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilder($alias, $entityAlias, array $codeList);

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList);

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder();

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByCodeQueryBuilder();

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder();

    /**
     * @param array|string[] $codeList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByCodeQueryBuilder(array $codeList);

    /**
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList);
}
