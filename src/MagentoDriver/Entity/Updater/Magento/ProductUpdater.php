<?php

namespace Luni\Component\MagentoDriver\Entity\Updater\Magento;

use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Luni\Component\MagentoDriver\Entity\Updater\AttributeUpdaterBrokerInterface;
use Luni\Component\MagentoDriver\Entity\Updater\MagentoProductUpdaterInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface;

class ProductUpdater
    implements MagentoProductUpdaterInterface
{
    /**
     * @var AttributeUpdaterBrokerInterface
     */
    private $attributeBroker;

    /**
     * @param AttributeUpdaterBrokerInterface $attributeBroker
     */
    public function __construct(
        AttributeUpdaterBrokerInterface $attributeBroker
    ) {
        $this->attributeBroker = $attributeBroker;
    }

    public function update(
        PimProductInterface $pimProduct,
        MagentoProductInterface $magentoProduct,
        $storeId = null
    ) {
        foreach ($pimProduct->getAttributes() as $attribute) {
            /** @var MagentoProductUpdaterInterface $attributeUpdater */
            $attributeUpdater = $this->attributeBroker->selectFor($attribute);

            if ($attributeUpdater === null) {
                continue;
            }

            $attributeUpdater->update($pimProduct, $magentoProduct, $storeId);
        }
    }
}