<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableAttributeValueInterface;

interface ImmutableAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return MutableAttributeValueInterface
     */
    public function switchToMutable();
}