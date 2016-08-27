<?php

namespace Kiboko\Component\MagentoDriver\Model;

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
