<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class AndWhereDoctrineFixForPHP7
 *
 * @package Kiboko\Component\MagentoORM
 * @internal
 * @deprecated
 */
trait AndWhereDoctrineFixForPHP7
{
    /**
     * Fix for PHP 7.0 and doctrine/dbal<2.5
     *
     * @param mixed ...$additionalWhere
     *
     * @return mixed
     *
     * @fixme: To be removed after migration to doctrine/dbal 2.5+
     * @deprecated
     * @internal
     */
    private function andWhere(QueryBuilder $queryBuilder, ...$additionalWhere)
    {
        $wherePart = $queryBuilder->getQueryPart('where');

        if ($wherePart instanceof CompositeExpression && $wherePart->getType() === CompositeExpression::TYPE_AND) {
            $wherePart->addMultiple(...$additionalWhere);
        } else {
            array_unshift($additionalWhere, $wherePart);
            $wherePart = new CompositeExpression(CompositeExpression::TYPE_AND, $additionalWhere);
        }

        return $queryBuilder->add('where', $wherePart, true);
    }
}
