<?php

namespace Luni\Component\MagentoMapper\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Luni\Component\MagentoMapper\QueryBuilder\FamilyQueryBuilderInterface;

class FamilyQueryBuilder
    implements FamilyQueryBuilderInterface
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
     * @param string $table
     * @param array $fields
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
            'attribute_set_id',
            'entity_type_id',
            'attribute_set_name',
            'sort_order',
        ];
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function getDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%sluni_pim_mapping_family', $prefix);
        }

        return 'luni_pim_mapping_family';
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function getFamilyDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute_set', $prefix);
        }

        return 'eav_attribute_set';
    }

    /**
     * @param array $fields
     * @param string $alias
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
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.family_code', $alias), '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        return $queryBuilder;
    }
}