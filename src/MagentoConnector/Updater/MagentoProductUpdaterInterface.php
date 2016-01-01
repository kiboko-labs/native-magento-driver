<?php

namespace Luni\Component\MagentoConnector\Updater;

use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Pim\Component\Catalog\Model\ProductInterface as PimProductInterface;

interface MagentoProductUpdaterInterface
{
    /**
     * @param PimProductInterface $pimProduct
     * @param MagentoProductInterface $magentoProduct
     * @param int $storeId
     * @return bool
     */
    public function update(
        PimProductInterface $pimProduct,
        MagentoProductInterface $magentoProduct,
        $storeId = null
    );
}