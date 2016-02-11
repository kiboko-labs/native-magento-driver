<?php

namespace Luni\Component\MagentoDriver\Mapper;

interface OptionMapperInterface
{
    /**
     * @param string $identifier
     * @return int
     */
    public function map($identifier);
}