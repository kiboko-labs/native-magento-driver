<?php

namespace Luni\Component\MagentoDriver\Backend\Attribute\StaticAttributes;

use Luni\Component\MagentoDriver\Backend\Attribute\BackendInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class SkuAttributeBackend
    implements BackendInterface
{
    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        // TODO: Implement persist() method.
    }

    public function initialize()
    {
        // TODO: Implement initialize() method.
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }
}