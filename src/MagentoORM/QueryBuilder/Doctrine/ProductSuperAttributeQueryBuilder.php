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

class ProductSuperAttributeQueryBuilder implements ProductSuperAttributeQueryBuilderInterface
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
        Connection $connection,
        $table,
        array $fields
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
            'product_super_attribute_id',
            'product_id',
            'attribute_id',
            'position',
        ];
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_super_attribute', $prefix);
        }

        return 'catalog_product_super_attribute';
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

    public function createFindOneByProductAndAttributeQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.product_id', $alias), '?'),
                $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    public function createFindAllQueryBuilder($alias)
    {
        return $this->createFindAllQueryBuilder($alias);
    }

    public function createFindAllByProductQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.product_id', $alias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllByAttributeQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?')
        );

        return $queryBuilder;
    }
}
