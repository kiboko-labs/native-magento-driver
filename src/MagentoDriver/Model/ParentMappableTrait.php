<?php

namespace Kiboko\Component\MagentoDriver\Model;

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
