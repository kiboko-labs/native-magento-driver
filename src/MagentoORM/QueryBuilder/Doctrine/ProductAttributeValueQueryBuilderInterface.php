<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductAttributeValueQueryBuilderInterface
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
    public function createFindAllFromStoreIdQueryBuilder($alias);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string $alias
     * @param array  $valueIds
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $valueIds);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdQueryBuilder($alias);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdQueryBuilder($alias);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias);

    /**
     * @param string $alias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductIdFromStoreIdQueryBuilder($alias, $variantAxisAlias);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $variantAxisAlias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdQueryBuilder($alias);
}
