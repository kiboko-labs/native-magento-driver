<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder\AttributeOptionValueQueryBuilderInterface;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;

class AttributeOptionValueQueryBuilder implements AttributeOptionValueQueryBuilderInterface
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
            'value_id',
            'option_code',
            'locale',
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
            return sprintf('%skiboko_pim_mapping_attribute_option_value', $prefix);
        }

        return 'kiboko_pim_mapping_attribute_option_value';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getAttributeOptionDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute_option_value', $prefix);
        }

        return 'eav_attribute_option_value';
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
    public function createFindOneByCodeAndLocaleQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.option_code', $alias), '?'),
                $queryBuilder->expr()->eq(sprintf('%s.locale', $alias), '?')
            )
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
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
}
