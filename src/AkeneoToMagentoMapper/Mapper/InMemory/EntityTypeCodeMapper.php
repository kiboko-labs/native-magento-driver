<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\InMemory;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeCodeMapperInterface;

class EntityTypeCodeMapper implements EntityTypeCodeMapperInterface
{
    use InMemoryMapperTrait;

    protected $mapping = [
        'Pim\\Bundle\\CatalogBundle\\Model\\Product' => 'catalog_product', // Akeneo v1.4
        'Pim\\Component\\Catalog\\Model\\Product'    => 'catalog_product', // Akeneo v1.5+
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
