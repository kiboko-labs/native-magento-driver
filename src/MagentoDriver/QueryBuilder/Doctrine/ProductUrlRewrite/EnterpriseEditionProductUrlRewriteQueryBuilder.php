<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductUrlRewrite;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class EnterpriseEditionProductUrlRewriteQueryBuilder
    implements EnterpriseEditionProductUrlRewriteQueryBuilderInterface
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
    private $mainTable;

    /**
     * @var string
     */
    private $productLinkTable;

    /**
     * @param Connection $connection
     * @param string     $mainTable
     * @param string     $productLinkTable
     * @param array      $fields
     */
    public function __construct(
        Connection $connection,
        $mainTable,
        $productLinkTable,
        array $fields
    ) {
        $this->connection = $connection;
        $this->mainTable = $mainTable;
        $this->productLinkTable = $productLinkTable;

        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'url_rewrite_id',
            'request_path',
            'target_path',
            'is_system',
            'guid',
            'identifier',
            'inc',
            'value_id',
            'store_id',
            'entity_type',
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
            return sprintf('%senterprise_url_rewrite', $prefix);
        }

        return 'enterprise_url_rewrite';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getProductLinkDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_entity_url_key', $prefix);
        }

        return 'catalog_product_entity_url_key';
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
            ->from($this->mainTable, $alias)
        ;
    }

    /**
     * @param string $alias
     * @param string $productLinkAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByProductIdQueryBuilder($alias, $productLinkAlias)
    {
        // TODO: Manage EE 1.13+ URL rewrites
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $queryBuilder->innerJoin($alias, $this->productLinkTable, $productLinkAlias,
            $queryBuilder->expr()->eq(
                sprintf('%s.value_id', $productLinkAlias),
                sprintf('%s.value_id', $alias)
            )
        );

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $productLinkAlias), '?'))
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $productLinkAlias), '?'))
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $productLinkAlias), '4'))
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.is_system', $productLinkAlias), '1'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }
}
