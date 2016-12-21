<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDML;

use Doctrine\DBAL\Connection;

trait InsertUpdateAwareTrait
{
    /**
     * Inserts a table row with specified data.
     *
     * @param Connection $connection       The name of the table to insert data into
     * @param string     $tableName        The name of the table to insert data into
     * @param array      $data             An associative array containing column-value pairs
     * @param array      $columns          The update criteria. An associative array containing columns
     * @param string     $identifierColumn
     * @param array      $types            Types of the inserted data
     *
     * @return int The number of affected rows
     */
    private function insertOnDuplicateUpdate(
        Connection $connection,
        $tableName,
        array $data,
        array $columns,
        $identifierColumn,
        array $types = []
    ) {
        $connection->connect();

        if (empty($data)) {
            return $connection->executeUpdate('INSERT INTO '.$tableName.' ()'.' VALUES ()');
        }

        $set = [
            sprintf('%1$s=LAST_INSERT_ID(%1$s)', $identifierColumn),
        ];
        $values = array_values($data);
        foreach ($columns as $columnName) {
            if (!isset($data[$columnName])) {
                continue;
            }

            $set[] = $columnName.' = ?';
            $values[] = $data[$columnName];
        }

        return $connection->executeUpdate(
            'INSERT INTO '.$tableName.' ('.implode(', ', array_keys($data)).')'.
            ' VALUES ('.implode(', ', array_fill(0, count($data), '?')).')'.
            ' ON DUPLICATE KEY UPDATE '.implode(', ', $set),
            $values,
            is_int(key($types)) ? $types : $this->extractTypeValues($data, $types)
        );
    }

    /**
     * Extract ordered type list from two associate key lists of data and types.
     *
     * @param array $data
     * @param array $types
     *
     * @return array
     */
    private function extractTypeValues(array $data, array $types)
    {
        $typeValues = [];

        foreach ($data as $k => $_) {
            $typeValues[] = isset($types[$k])
                ? $types[$k]
                : \PDO::PARAM_STR;
        }

        return $typeValues;
    }
}
