<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\InMemory;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\ProductMapperInterface;

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
