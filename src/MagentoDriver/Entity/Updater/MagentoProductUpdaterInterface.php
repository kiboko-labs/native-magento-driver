<?php

namespace Luni\Component\MagentoDriver\Entity\Updater;

use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface;

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