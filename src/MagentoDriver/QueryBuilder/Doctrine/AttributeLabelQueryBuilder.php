<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class AttributeGroupQueryBuilder implements AttributeGroupQueryBuilderInterface
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
    )
    {
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
            'default_id'
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
                        ->select($this->createFieldsList($this->fields, $alias))
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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_group_id', $alias), '?'))
                ->setFirstResult(0)
                ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * 
     * @param string $alias
     * @param int[] $idList
     * @return type
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_group_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_group_name', $alias), '?'))
                ->setFirstResult(0)
                ->setMaxResults(1)
        ;

        return $queryBuilder;
    }
    
    /**
     * 
     * @param string   $alias
     * @param string[] $nameList
     * @return type
     */
    public function createFindAllByNameQueryBuilder($alias, array $nameList)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $expr = array_pad([], count($nameList), $queryBuilder->expr()->eq(sprintf('%s.attribute_group_name', $alias), '?'));
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
        ;
    }

    /**
     * @param int $id
     * 
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('attribute_group_id', '?'))
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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('attribute_group_name', '?'))
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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

}
