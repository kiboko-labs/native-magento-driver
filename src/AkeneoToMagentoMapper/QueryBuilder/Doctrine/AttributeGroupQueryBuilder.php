<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder\AttributeGroupQueryBuilderInterface;
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
            'attribute_group_id',
            'attribute_group_code',
            'family_code',

            'instance_identifier',
            'mapping_class',
            'mapping_options',
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
            return sprintf('%skiboko_pim_mapping_attribute_group', $prefix);
        }

        return 'kiboko_pim_mapping_attribute_group';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getAttributeGroupDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute_group', $prefix);
        }

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
    public function createFindOneByCodeQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $this
            ->andWhere(
                $queryBuilder,
                $queryBuilder->expr()->eq(sprintf('%s.attribute_group_code', $alias), '?'),
                $queryBuilder->expr()->eq(sprintf('%s.family_code', $alias), '?')
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
