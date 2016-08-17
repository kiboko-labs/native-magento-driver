<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Pim\Component\Catalog\Model\EntityTypeMapperInterface;

class EntityTypeMapper implements EntityTypeMapperInterface
{
    use InMemoryMapperTrait;

    protected $mapping = [
        'Pim\\Bundle\\CatalogBundle\\Model\\Product' => 4, // Version 1.4
        'Pim\\Component\\Catalog\\Model\\Product'    => 4, // Version 1.5+
    ];

    /**
     * @param array|null $mapping
     */
    public function __construct(
        array $mapping = null
    ) {
        if ($mapping !== null) {
            $this->mapping = $mapping;
        }
    }
}
