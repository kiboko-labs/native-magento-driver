<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento20;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface as BaseAttributeGroupInterface;

interface AttributeGroupInterface extends BaseAttributeGroupInterface
{
    /**
     * @return string
     *
     * @since magento 2.0
     */
    public function getAttributeGroupCode();

    /**
     * @return string
     *
     * @since magento 2.0
     */
    public function getTabGroupCode();
}
