<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Mapper\OptionMapperInterface;

class DefaultOptionMapper implements OptionMapperInterface
{
    use InMemoryMapperTrait;

    /**
     * @var array
     */
    protected $mapping = [];

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
