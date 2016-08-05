<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Pim\Component\Catalog\Model\AttributeInterface;

class DefaultEntityTypeMapper implements EntityTypeMapperInterface
{
    private $mapping = [
        \Pim\Component\Catalog\Model\Product::class => 4,
    ];

    /**
     * @param AttributeInterface $identifier
     *
     * @return mixed|void
     */
    public function map(AttributeInterface $identifier)
    {
        if (!isset($this->mapping[$identifier->getEntityType()])) {
            return;
        }

        return $this->mapping[$identifier->getEntityType()];
    }
}
