<?php

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductUrlRewrite;

use Doctrine\DBAL\Query\QueryBuilder;

interface EnterpriseEditionProductUrlRewriteQueryBuilderInterface
{
    /**
     * @param string $alias
     * @param string $productLinkAlias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdQueryBuilder($alias, $productLinkAlias);
}