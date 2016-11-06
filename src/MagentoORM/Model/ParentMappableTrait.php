<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

trait ParentMappableTrait
{
    use MappableTrait;

    private $parentMappingCode;

    /**
     * @param string $code
     */
    public function setParentMappingCode($code)
    {
        $this->parentMappingCode = $code;
    }

    /**
     * @return string
     */
    public function getParentMappingCode()
    {
        return $this->parentMappingCode;
    }
}
