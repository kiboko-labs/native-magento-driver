<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

trait AttributeQueryBuilderTrait
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $extraFields;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $extraTable;

    /**
     * @param array $fields
     * @param string $alias
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
     * @param string $extraAlias
     * @param array $excludedIds
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias, $extraAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindQueryBuilder($alias)
            ->innerJoin($alias, $this->extraTable, $extraAlias,
                sprintf('%s.attribute_id=%s.attribute_id', $extraAlias, $alias))
            ->addSelect($this->createFieldsList($this->extraFields, $extraAlias))
            ->where(sprintf('%s.entity_type_id=4', $alias))
        ;

        if (count($excludedIds) > 0) {
            $expr = array_pad([], count($excludedIds), $queryBuilder->expr()->neq(sprintf('%s.attribute_id', $alias), '?'));
            $queryBuilder->andWhere($queryBuilder->expr()->andX(...$expr));
        }

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias, $extraAlias)
    {
        return $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->where(sprintf('%s.attribute_code = ?', $alias))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias, $extraAlias)
    {
        return $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->where(sprintf('%s.attribute_id = ?', $alias))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param array|string[] $codeList
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilder($alias, $extraAlias, array $codeList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias);

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param array|int[] $idList
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, $extraAlias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder()
    {
        return (new QueryBuilder($this->connection))
            ->delete($this->table)
            ->where('entity_type_id=4')
        ;
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
     * @return QueryBuilder
     */
    public function createDeleteAllByCodeQueryBuilder(array $codeList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq('attribute_code', '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param array|int[] $idList
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('attribute_id', '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }
}