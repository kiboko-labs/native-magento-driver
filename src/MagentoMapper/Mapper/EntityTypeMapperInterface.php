<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Pim\Component\Catalog\Model\AttributeInterface;

interface EntityTypeMapperInterface
{
    /**
     * @param AttributeInterface $identifier
     *
     * @return int
     */
    public function map(AttributeInterface $identifier);
}
