<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

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
            ->andWhere(sprintf('%s.entity_type_id=4', $alias))
        ;

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

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_type_code', $entityAlias), '?'));

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
        return $this->createFindAllByEntityTypeQueryBuilderWithExtra($alias, $extraAlias, $entityAlias)
            ->andWhere(sprintf('%s.attribute_code = ?', $alias))
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
        return $this->createFindAllQueryBuilderWithExtra($alias, $extraAlias)
            ->andWhere(sprintf('%s.attribute_id = ?', $alias))
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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }
}
