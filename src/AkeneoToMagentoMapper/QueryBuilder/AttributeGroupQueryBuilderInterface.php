<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

interface AttributeGroupQueryBuilderInterface
{
    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias);
}
