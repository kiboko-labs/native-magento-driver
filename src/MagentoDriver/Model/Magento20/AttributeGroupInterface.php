<?php

namespace Kiboko\Component\MagentoDriver\Model\Magento20;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface as BaseAttributeGroupInterface;

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
