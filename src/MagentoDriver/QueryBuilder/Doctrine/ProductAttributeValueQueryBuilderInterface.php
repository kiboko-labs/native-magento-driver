<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductAttributeValueQueryBuilderInterface
{
    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * @param string $alias
     * @param array $excludedIds
     * @return QueryBuilder
     */
    public function createFindAllFromDefaultQueryBuilder($alias, array $excludedIds = []);

    /**
     * @param string $alias
     * @param int $storeId
     * @param array $excludedIds
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdQueryBuilder($alias, $storeId, array $excludedIds = []);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param int $storeId
     * @param array $excludedIds
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $storeId, array $excludedIds = []);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias);

    /**
     * @param string $alias
     * @param int $productId
     * @param int $attributeId
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromDefaultQueryBuilder($alias, $productId, $attributeId);

    /**
     * @param string $alias
     * @param int $storeId
     * @param int $productId
     * @param int $attributeId
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdQueryBuilder($alias, $storeId, $productId, $attributeId);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param int $storeId
     * @param int $productId
     * @param int $attributeId
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $storeId, $productId, $attributeId);

    /**
     * @param string $alias
     * @param int $productId
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromDefaultQueryBuilder($alias, $productId);

    /**
     * @param string $alias
     * @param int $storeId
     * @param int $productId
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdQueryBuilder($alias, $storeId, $productId);

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param int $storeId
     * @param int $productId
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $storeId, $productId);
}