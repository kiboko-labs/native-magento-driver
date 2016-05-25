<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

class DefaultEntityTypeMapper implements EntityTypeMapperInterface
{
    private $mapping = [
        \Pim\Bundle\CatalogBundle\Model\Product::class => 4,
    ];

    public function map($identifier)
    {
        if (!isset($this->mapping[$identifier])) {
            return;
        }

        return $this->mapping[$identifier];
    }
}
