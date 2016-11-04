<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface EntityAttributeQueryBuilderInterface
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
     * @param int    $attributeId
     * @param int    $attributeGroupId
     *
     * @return QueryBuilder
     */
    public function createFindOneByAttributeIdAndGroupIdQueryBuilder($alias, $attributeId, $attributeGroupId);

    /**
     * @param string $alias
     * @param int    $attributeId
     * @param int    $attributeSetId
     *
     * @return QueryBuilder
     */
    public function createFindOneByAttributeIdAndSetIdQueryBuilder($alias, $attributeId, $attributeSetId);

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
    public function createDeleteOneByIdQueryBuilder();

    /**
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList);
}
