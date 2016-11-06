<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableAttributeValueInterface;

interface MutableAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return ImmutableAttributeValueInterface
     */
    public function switchToImmutable();
}
