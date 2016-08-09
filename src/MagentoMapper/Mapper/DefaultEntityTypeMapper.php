<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Pim\Component\Catalog\Model\AttributeInterface;

class DefaultEntityTypeMapper implements EntityTypeMapperInterface
{
    private $mapping = [
        'Pim\\Bundle\\CatalogBundle\\Model\\Product' => 4, // Version 1.4
        'Pim\\Component\\Catalog\\Model\\Product'    => 4, // Version 1.5+
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
