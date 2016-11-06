<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Mutable;

use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface;

interface MutableAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return ImmutableAttributeValueInterface
     */
    public function switchToImmutable();
}
