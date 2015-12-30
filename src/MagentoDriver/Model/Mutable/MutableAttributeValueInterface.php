<?php

namespace Luni\Component\MagentoDriver\ModelValue\Mutable;

use Luni\Component\MagentoDriver\ModelValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\Immutable\ImmutableAttributeValueInterface;

interface MutableAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return ImmutableAttributeValueInterface
     */
    public function switchToImmutable();
}