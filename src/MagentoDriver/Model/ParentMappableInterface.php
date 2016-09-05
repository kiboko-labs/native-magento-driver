<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface ParentMappableInterface extends MappableInterface
{
    /**
     * @param string $code
     */
    public function setParentMappingCode($code);

    /**
     * @return string
     */
    public function getParentMappingCode();
}
