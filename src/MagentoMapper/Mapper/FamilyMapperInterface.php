<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

interface FamilyMapperInterface
{
    /**
     * @param string $identifier
     *
     * @return int
     */
    public function map($identifier);
}
