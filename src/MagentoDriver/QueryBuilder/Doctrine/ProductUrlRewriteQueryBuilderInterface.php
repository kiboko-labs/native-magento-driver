<?php

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface ProductUrlRewriteQueryBuilderInterface
{
    /**
     * @param string $alias
     * @param string $productLinkAlias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdQueryBuilder($alias, $productLinkAlias);
}