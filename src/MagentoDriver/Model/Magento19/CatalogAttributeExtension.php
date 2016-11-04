<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Magento19;

use Kiboko\Component\MagentoDriver\Model\AbstractCatalogAttributeExtension;

class CatalogAttributeExtension extends AbstractCatalogAttributeExtension implements CatalogAttributeExtensionInterface
{
    /**
     * @var bool
     */
    private $configurable;

    /**
     * @return bool
     */
    public function isConfigurable()
    {
        return $this->configurable;
    }
}
