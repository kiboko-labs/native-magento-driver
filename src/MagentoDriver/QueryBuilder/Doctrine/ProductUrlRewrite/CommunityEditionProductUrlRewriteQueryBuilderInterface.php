<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductUrlRewrite;

use Doctrine\DBAL\Query\QueryBuilder;

interface CommunityEditionProductUrlRewriteQueryBuilderInterface
{
    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdQueryBuilder($alias);
}
