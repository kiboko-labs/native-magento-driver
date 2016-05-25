<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface EntityTypeMapperInterface
{
    /**
     * @param string $identifier
     *
     * @return int
     */
    public function map($identifier);
}
