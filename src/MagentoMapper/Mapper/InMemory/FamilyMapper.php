<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Mapper\FamilyMapperInterface;

class FamilyMapper implements FamilyMapperInterface
{
    use InMemoryMapperTrait;

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
