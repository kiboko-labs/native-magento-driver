<?php

namespace Luni\Component\MagentoDriver\ModelValue\Immutable;

use Luni\Component\MagentoDriver\ModelValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\Mutable\MutableAttributeValueInterface;

interface ImmutableAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return MutableAttributeValueInterface
     */
    public function switchToMutable();
}