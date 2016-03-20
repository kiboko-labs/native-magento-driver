<?php

namespace Luni\Component\MagentoMapper\SchemaManager;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;

interface MappingSchemaManagerInterface
{
    /**
     * @return bool
     */
    public function assertTableExists();

    /**
     *
     */
    public function createTable();

    /**
     * @param string $pimgentoTableName
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName);
}