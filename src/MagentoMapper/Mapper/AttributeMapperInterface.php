<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeMapperInterface
{
    /**
     * @param string $identifier
     *
     * @return AttributeInterface
     */
    public function map($identifier);
}
