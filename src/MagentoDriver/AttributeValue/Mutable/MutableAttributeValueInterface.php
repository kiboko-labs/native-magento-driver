<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableAttributeValueInterface;

interface MutableAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return ImmutableAttributeValueInterface
     */
    public function switchToImmutable();
}