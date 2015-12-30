<?php

namespace Luni\Component\MagentoDriver\Backend\AttributeValue;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class StaticAttributeBackend
    implements BackendInterface
{
    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
    }

    public function initialize()
    {
    }

    public function flush()
    {
    }
}