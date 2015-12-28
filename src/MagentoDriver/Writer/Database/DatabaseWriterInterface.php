<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

interface DatabaseWriterInterface
{
    /**
     * @param string $table
     * @param string[]|array $tableFields
     * @return void
     */
    public function write($table, array $tableFields);
}