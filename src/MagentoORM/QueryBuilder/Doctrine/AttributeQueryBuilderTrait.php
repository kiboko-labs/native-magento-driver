<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

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
     * @param string $extraAlias
     * @param array  $excludedIds
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias, $extraAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindQueryBuilder($alias)
//            ->innerJoin($alias, $this->extraTable, $extraAlias,
//                sprintf('%s.attribute_id=%s.attribute_id', $extraAlias, $alias))
//            ->addSelect($this->createFieldsList($this->extraFields, $extraAlias))
//            ->andWhere(sprintf('%s.entity_type_id=4', $alias))
        ;

        if (count($excludedIds) > 0) {
            //            $expr = array_pad([], count($excludedIds), $queryBuilder->expr()->neq(sprintf('%s.attribute_id', $alias), '?'));
//            $queryBuilder->andWhere($queryBuilder->expr()->andX(...$expr));
        }

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
    public function createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias, array $excludedIds = [])
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias, $excludedIds);

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
    public function createFindOneByCodeQueryBuilder($alias, $extraAlias, $entityAlias)
    {
        return $this->createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias)
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
    public function createFindOneByIdQueryBuilder($alias, $extraAlias)
    {
        return $this->createFindAllQueryBuilder($alias, $extraAlias)
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
    public function createFindAllByCodeQueryBuilder($alias, $extraAlias, $entityAlias, array $codeList)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias);

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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }
}
