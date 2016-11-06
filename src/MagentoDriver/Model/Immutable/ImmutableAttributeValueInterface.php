<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Immutable;

use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableAttributeValueInterface;

interface ImmutableAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return MutableAttributeValueInterface
     */
    public function switchToMutable();
}
