<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class EntityAttributeQueryBuilder implements EntityAttributeQueryBuilderInterface
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
            'entity_attribute_id',
            'entity_type_id',
            'attribute_set_id',
            'attribute_group_id',
            'attribute_id',
            'sort_order',
        ];
    }

    /**
     * @return string eav_entity_attribute
     */
    public static function getDefaultTable()
    {
        return 'eav_entity_attribute';
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
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_attribute_id', $alias), '?'))
                ->setFirstResult(0)
                ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    public function createFindOneByAttributeIdAndGroupIdQueryBuilder($alias, $attributeId, $attributeGroupId)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), $attributeId))
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_group_id', $alias), $attributeGroupId))
                ->setFirstResult(0)
                ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    public function createFindOneByAttributeIdAndSetIdQueryBuilder($alias, $attributeId, $attributeSetId)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), $attributeId))
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $alias), $attributeSetId))
                ->setFirstResult(0)
                ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param int[]  $idList
     *
     * @return type
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.entity_attribute_id', $alias), '?'));
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
                ->andWhere($queryBuilder->expr()->eq('entity_attribute_id', '?'))
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

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('entity_attribute_id', '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }
}
