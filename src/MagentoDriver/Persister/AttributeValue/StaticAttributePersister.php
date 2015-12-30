<?php

namespace Luni\Component\MagentoDriver\Persister\AttributeValue;

use Luni\Component\MagentoDriver\ModelValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class StaticAttributePersister
    implements PersisterInterface
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