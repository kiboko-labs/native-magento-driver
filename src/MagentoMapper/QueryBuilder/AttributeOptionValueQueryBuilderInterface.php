<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

interface AttributeOptionValueQueryBuilderInterface
{
    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeAndLocaleQueryBuilder($alias);

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias);
}
