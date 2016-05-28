<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface OptionMapperInterface
{
    /**
     * @param string $identifier
     *
     * @return int
     */
    public function map($identifier);
}
