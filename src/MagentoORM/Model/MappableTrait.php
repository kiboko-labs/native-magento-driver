<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

trait MappableTrait
{
    private $mappingCode;

    /**
     * @param string $code
     */
    public function setMappingCode($code)
    {
        $this->mappingCode = $code;
    }

    /**
     * @return string
     */
    public function getMappingCode()
    {
        return $this->mappingCode;
    }
}
