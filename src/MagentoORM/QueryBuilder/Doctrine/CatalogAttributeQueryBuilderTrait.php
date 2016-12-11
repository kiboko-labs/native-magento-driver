<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;

trait CatalogAttributeQueryBuilderTrait
{
    use AttributeQueryBuilderTrait;

    /**
     * @var array
     */
    private $extraFields;

    /**
     * @var string
     */
    private $extraTable;

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilderWithExtra($alias, $extraAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $excludedIds)
            ->innerJoin($alias, $this->extraTable, $extraAlias,
                sprintf('%s.attribute_id=%s.attribute_id', $extraAlias, $alias))
        ;

        $this->andWhere(
            $queryBuilder,
            sprintf('%s.entity_type_id=4', $alias)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindAllQueryBuilderWithExtra($alias, $extraAlias, $excludedIds);

        $queryBuilder->innerJoin($alias, $this->entityTable, $entityAlias,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $entityAlias), sprintf('%s.entity_type_id', $alias))
        );

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_code', $entityAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilderWithExtra($alias, $extraAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilderWithExtra($alias, $extraAlias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string         $alias
     * @param string         $extraAlias
     * @param string         $entityAlias
     * @param array|string[] $codeList
     *
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias, array $codeList)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias);

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string      $alias
     * @param string      $extraAlias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilderWithExtra($alias, $extraAlias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilderWithExtra($alias, $extraAlias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }
}
