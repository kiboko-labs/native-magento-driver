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

class EntityStoreQueryBuilder implements EntityStoreQueryBuilderInterface
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
     * @param Connection $connection
     * @param string     $table
     * @param array      $fields
     */
    public function __construct(
    Connection $connection, $table, array $fields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'entity_store_id',
            'entity_type_id',
            'store_id',
            'increment_prefix',
            'increment_last_id',
        ];
    }

    /**
     * @return string
     */
    public static function getDefaultTable()
    {
        return 'eav_entity_store';
    }

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
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

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
                $queryBuilder->expr()->eq(sprintf('%s.entity_store_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1);

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array  $storeIdList
     *
     * @return QueryBuilder
     */
    public function createFindAllByStoreIdQueryBuilder($alias, array $storeIdList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($storeIdList), $queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByStoreIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1);

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array  $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.entity_store_id', $alias), '?'));
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
        return (new QueryBuilder($this->connection))
            ->delete($this->table);
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $queryBuilder->where(
            $queryBuilder->expr()->eq('entity_store_id', '?')
        );

        return $queryBuilder;
    }

    /**
     * @param array $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('entity_store_id', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByTypeIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string      $alias
     * @param array|int[] $typeIdList
     *
     * @return QueryBuilder
     */
    public function createFindAllByTypeIdQueryBuilder($alias, array $typeIdList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($typeIdList), $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }
}
