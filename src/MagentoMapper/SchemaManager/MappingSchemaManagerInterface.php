<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\SchemaManager;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;

interface MappingSchemaManagerInterface
{
    /**
     * @param Schema     $currentSchema
     * @param SchemaDiff $schemaDiff
     *
     * @return SchemaDiff
     */
    public function schemaDiff(Schema $currentSchema, SchemaDiff $schemaDiff);

    /**
     * @param string $pimgentoTableName
     * @param string $linkCode
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName, $linkCode);

    /**
     * @return string
     */
    public function getTableName();
}
