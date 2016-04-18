<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class EntityStoreQueryBuilder implements EntityStoreQueryBuilderInterface
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

        $queryBuilder->where($queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $alias), 4)
        ));

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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_store_id', $alias), '?'))
                ->setFirstResult(0)
                ->setMaxResults(1);

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array  $storeIdList
     */
    public function createFindAllByStoreIdQueryBuilder($alias, array $storeIdList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($storeIdList), $queryBuilder->expr()->eq(sprintf('%s.entity_store_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?'))
                ->setFirstResult(0)
                ->setMaxResults(1);

        return $queryBuilder;
    }

    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.entity_store_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder()
    {
        
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('entity_store_id', '?'))
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

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('entity_store_id', '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

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

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $alias), '?'))
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
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

}
