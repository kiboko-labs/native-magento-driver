<?php

namespace Luni\Component\MagentoDriver\Mapper;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeMapperInterface
{
    /**
     * @param string $identifier
     * @return AttributeInterface
     */
    public function map($identifier);
}