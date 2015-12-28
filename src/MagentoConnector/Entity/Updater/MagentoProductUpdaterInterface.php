<?php

namespace Luni\Component\MagentoConnector\Entity\Updater;

use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface; // TODO: change to Pim\Component\Catalog\Model\ProductInterface in 1.5

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