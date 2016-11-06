<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Comparator as SchemaComparator;

class AttributeOptionMappingSchemaManager extends AbstractMappingSchemaManager
{
    /**
     * @var string
     */
    private $attributeOptionTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection       $connection
     * @param SchemaComparator $schemaComparator
     * @param string           $tableName
     * @param string           $attributeOptionTableName
     */
    public function __construct(
        Connection $connection,
        SchemaComparator $schemaComparator,
        $tableName,
        $attributeOptionTableName
    ) {
        parent::__construct($connection, $schemaComparator, $tableName);
        $this->attributeOptionTableName = $attributeOptionTableName;
    }

    /**
     * @return Table
     */
    protected function declareTable()
    {
        $table = new Table($this->tableName);

        $table->addColumn('option_id', 'integer', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64,
        ]);

        $table->addColumn('option_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'text');

        $table->addIndex(['option_id']);

        $table->addIndex(['option_code']);

        $table->addUniqueIndex(['instance_identifier', 'option_id']);

        $table->addForeignKeyConstraint(
            $this->attributeOptionTableName,
            [
                'option_id',
            ],
            [
                'option_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );

        return $table;
    }

    /**
     * @param string $pimgentoTableName
     * @param string $linkCode
     *
     * @return int|null
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName, $linkCode)
    {
        $manager = $this->connection->getSchemaManager();

        if (!$manager->tablesExist([$pimgentoTableName])) {
            return;
        }

        $queryBuilder = new QueryBuilder($this->connection);

        $queryBuilder
            ->select([
                'option_id' => 'pim.entity_id',
                'instance_identifier' => $queryBuilder->expr()->literal($linkCode),
                'option_code' => 'INSERT(pim.code, LOCATE(CONCAT(pim2.code, "_"), pim.code), LENGTH(CONCAT(pim2.code, "_")), "")',
                'mapping_class' => 'NULL',
                'mapping_options' => $queryBuilder->expr()->literal(json_encode([], JSON_OBJECT_AS_ARRAY)),
            ])
            ->from($pimgentoTableName, 'pim')
            ->innerJoin('pim', 'eav_attribute_option', 'ao', $queryBuilder->expr()->eq('ao.option_id', 'pim.entity_id'))
            ->innerJoin('pim', $pimgentoTableName, 'pim2', $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq('ao.attribute_id', 'pim2.entity_id'),
                $queryBuilder->expr()->eq('pim2.import', $queryBuilder->expr()->literal('attribute'))
            ))
            ->where($queryBuilder->expr()->eq('pim.import', $queryBuilder->expr()->literal('option')))
        ;

        return $this->connection->executeUpdate(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL()
        );
    }
}
