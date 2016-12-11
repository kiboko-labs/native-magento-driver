<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;

trait AttributeQueryBuilderTrait
{
    use AndWhereDoctrineFixForPHP7;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $entityTable;

    /**
     * @param array  $fields
     * @param string $alias
     *
     * @return array
     */
    protected function createFieldsList(array $fields, $alias)
    {
        $outputFields = [];
        foreach ($fields as $field) {
            $outputFields[] = sprintf('%s.%s', $alias, $field);
        }

        return $outputFields;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindQueryBuilder($alias)
    {
        return (new QueryBuilder($this->connection))
            ->select($this->createFieldsList($this->fields, $alias))
            ->from($this->table, $alias)
        ;
    }

    /**
     * @param string $alias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        if (count($excludedIds) > 0) {
            $expr = array_pad([], count($excludedIds), $queryBuilder->expr()->neq(sprintf('%s.attribute_id', $alias), '?'));
            $this->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->andX(...$expr)
            );
        }

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $entityAlias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllByEntityTypeQueryBuilder($alias, $entityAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $excludedIds);

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
     * @param string $entityAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias, $entityAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $entityAlias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string         $alias
     * @param string         $entityAlias
     * @param array|string[] $codeList
     *
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilder($alias, $entityAlias, array $codeList)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $entityAlias);

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder()
    {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder->delete($this->table);

        if ($this->table !== 'catalog_eav_attribute') {
            $queryBuilder->where('entity_type_id=4');
        }

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByCodeQueryBuilder()
    {
        return $this->createDeleteQueryBuilder()
            ->where('attribute_code = ?')
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        return $this->createDeleteQueryBuilder()
            ->where('attribute_id = ?')
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param array|string[] $codeList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByCodeQueryBuilder(array $codeList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq('attribute_code', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('attribute_id', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }
}
