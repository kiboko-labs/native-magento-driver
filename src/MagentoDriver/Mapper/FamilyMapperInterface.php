<?php

namespace Luni\Component\MagentoDriver\Mapper;

interface FamilyMapperInterface
{
    /**
     * @param string $identifier
     * @return int
     */
    public function map($identifier);
}