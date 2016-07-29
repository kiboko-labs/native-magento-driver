<?php

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface CommunityEditionProductUrlRewriteQueryBuilderInterface
{
    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdQueryBuilder($alias);
}