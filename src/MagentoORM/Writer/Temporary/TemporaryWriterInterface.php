<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Writer\Temporary;

interface TemporaryWriterInterface
{
    /**
     * @param array $row
     */
    public function persistRow(array $row);

    public function flush();
}
