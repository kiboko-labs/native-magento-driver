<?php

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
