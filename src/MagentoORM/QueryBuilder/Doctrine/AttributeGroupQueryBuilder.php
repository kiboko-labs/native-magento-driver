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

class AttributeGroupQueryBuilder implements AttributeGroupQueryBuilderInterface
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
            'attribute_group_id',
            'attribute_set_id',
            'attribute_group_name',
            'sort_order',
            'default_id',
            'attribute_group_code',
            'tab_group_code',
        ];
    }

    /**
     * @return string
     */
    public static function getDefaultTable()
    {
        return 'eav_attribute_group';
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
                        ->select($this->createFieldsList(['*'], $alias))
                        ->from($this->table, $alias)
        ;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_group_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param int[]  $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_group_id', $alias), '?'));
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
    public function createFindOneByNameQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_group_name', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string   $alias
     * @param string[] $nameList
     *
     * @return QueryBuilder
     */
    public function createFindAllByNameQueryBuilder($alias, array $nameList)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $expr = array_pad([], count($nameList), $queryBuilder->expr()->eq(sprintf('%s.attribute_group_name', $alias), '?'));
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
            ->delete($this->table)
        ;
    }

    /**
     * @param int $identifier
     *
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq('attribute_group_id', '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

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

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('attribute_group_id', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string $name
     *
     * @return QueryBuilder
     */
    public function createDeleteOneByNameQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq('attribute_group_name', '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param array|string[] $nameList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByNameQueryBuilder(array $nameList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($nameList), $queryBuilder->expr()->eq('attribute_group_name', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }
}
