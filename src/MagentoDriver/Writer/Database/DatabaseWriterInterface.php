<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

interface DatabaseWriterInterface
{
    /**
     * @param string $table
     * @param string[]|array $tableFields
     * @param \Generator $messenger
     * @return int
     */
    public function write($table, array $tableFields, \Generator $messenger = null);
}