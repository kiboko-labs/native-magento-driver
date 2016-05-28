<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface AttributeMapperInterface
{
    /**
     * @param string $identifier
     *
     * @return int
     */
    public function map($identifier);
}
