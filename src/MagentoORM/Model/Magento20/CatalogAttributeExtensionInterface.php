<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento20;

use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface as BaseCatalogAttributeExtensionInterface;

interface CatalogAttributeExtensionInterface
    extends BaseCatalogAttributeExtensionInterface
{
    /**
     * @return bool
     */
    public function isRequiredInAdminStore();

    /**
     * @return bool
     */
    public function isUsedInGrid();

    /**
     * @return bool
     */
    public function isVisibleInGrid();

    /**
     * @return bool
     */
    public function isFilterableInGrid();

    /**
     * @return int
     */
    public function getSearchWeight();

    /**
     * @return array
     */
    public function getAdditionalData();
}
