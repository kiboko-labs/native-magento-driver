<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Mapper\ProductMapperInterface;

class ProductMapper implements ProductMapperInterface
{
    use InMemoryMapperTrait;

    /**
     * @var array
     */
    private $mapping = [];

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
