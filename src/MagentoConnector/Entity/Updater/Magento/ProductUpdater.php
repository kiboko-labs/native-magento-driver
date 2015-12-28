<?php

namespace Luni\Component\MagentoConnector\Entity\Updater\Magento;

use Luni\Component\MagentoConnector\Broker\AttributeUpdaterBrokerInterface;
use Luni\Component\MagentoConnector\Entity\Updater\MagentoProductUpdaterInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface; // TODO: change to Pim\Component\Catalog\Model\ProductInterface in 1.5

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