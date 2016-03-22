<?php

namespace Luni\Component\MagentoMapper\SchemaManager;

interface MappingSchemaManagerInterface
{
    /**
     * @return bool
     */
    public function assertTableExists();

    public function createTable();

    /**
     * @param string $pimgentoTableName
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName);
}
