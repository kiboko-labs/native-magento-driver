<?php

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml;

use Doctrine\DBAL\Connection;

trait InsertUpdateAwareTrait
{
    /**
     * Inserts a table row with specified data.
     *
     * @param Connection $connection The name of the table to insert data into.
     * @param string $tableName  The name of the table to insert data into.
     * @param array  $data       An associative array containing column-value pairs.
     * @param array  $columns    The update criteria. An associative array containing columns.
     * @param array  $types      Types of the inserted data.
     *
     * @return integer The number of affected rows.
     */
    private function insertOnDuplicateUpdate(
        Connection $connection,
        $tableName,
        array $data,
        array $columns,
        array $types = array()
    ) {
        $connection->connect();

        if (empty($data)) {
            return $connection->executeUpdate('INSERT INTO ' . $tableName . ' ()' . ' VALUES ()');
        }

        $set = [];
        $values = array_values($data);
        foreach ($columns as $columnName) {
            if (!isset($data[$columnName])) {
                continue;
            }

            $set[] = $columnName . ' = ?';
            $values[] = $data[$columnName];
        }

        return $connection->executeUpdate(
            'INSERT INTO ' . $tableName . ' (' . implode(', ', array_keys($data)) . ')' .
            ' VALUES (' . implode(', ', array_fill(0, count($data), '?')) . ')' .
            ' ON DUPLICATE KEY UPDATE '  . implode(', ', $set),
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
        $typeValues = array();

        foreach ($data as $k => $_) {
            $typeValues[] = isset($types[$k])
                ? $types[$k]
                : \PDO::PARAM_STR;
        }

        return $typeValues;
    }
}