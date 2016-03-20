<?php

namespace Luni\Component\MagentoMapper\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

interface OptionQueryBuilderInterface
{
    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByAttributeQueryBuilder($alias);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByAttributeCodeQueryBuilder($alias);

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllByAttributeQueryBuilder($alias);
}