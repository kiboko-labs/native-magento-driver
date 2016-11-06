<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface MappableInterface
{
    /**
     * @param string $code
     */
    public function setMappingCode($code);

    /**
     * @return string
     */
    public function getMappingCode();
}
