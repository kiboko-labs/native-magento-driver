<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento20;

interface ImmutableAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return MutableAttributeValueInterface
     */
    public function switchToMutable();
}
