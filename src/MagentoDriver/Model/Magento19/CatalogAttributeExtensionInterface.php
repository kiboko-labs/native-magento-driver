<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Magento19;

use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface as BaseCatalogAttributeExtensionInterface;

interface CatalogAttributeExtensionInterface
    extends BaseCatalogAttributeExtensionInterface
{
    /**
     * @return bool
     */
    public function isConfigurable();
}
