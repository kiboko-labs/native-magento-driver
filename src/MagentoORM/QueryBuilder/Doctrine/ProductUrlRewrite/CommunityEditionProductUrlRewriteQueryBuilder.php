<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductUrlRewrite;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class CommunityEditionProductUrlRewriteQueryBuilder implements CommunityEditionProductUrlRewriteQueryBuilderInterface
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
            'url_rewrite_id',
            'store_id',
            'category_id',
            'product_id',
            'id_path',
            'request_path',
            'target_path',
            'is_system',
            'options',
            'description',
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
            return sprintf('%score_url_rewrite', $prefix);
        }

        return 'core_url_rewrite';
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
    public function createFindOneByProductIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.product_id', $alias), '?'))
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?'))
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.is_system', $alias), '1'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }
}
