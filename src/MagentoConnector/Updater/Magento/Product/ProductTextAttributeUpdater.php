<?php

namespace Luni\Component\MagentoConnector\Updater\Magento\Product;

use Luni\Component\MagentoDriver\Model\AttributeInterface as MagentoAttributeInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableTextAttributeValue;
use Luni\Component\MagentoDriver\Model\Mutable\MutableAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableTextAttributeValue;
use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Luni\Component\MagentoConnector\Updater\MagentoProductUpdaterInterface;
use Luni\Component\MagentoDriver\Exception\ImmutableValueException;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface as PimAttributeInterface; // TODO: change to Pim\Component\Catalog\Model\AttributeInterface in 1.5
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface;     // TODO: change to Pim\Component\Catalog\Model\ProductInterface in 1.5

class ProductTextAttributeUpdater
    implements MagentoProductUpdaterInterface
{
    /**
     * @var PimAttributeInterface
     */
    private $pimAttribute;

    /**
     * @var MagentoAttributeInterface
     */
    private $magentoAttribute;

    /**
     * @param PimAttributeInterface $pimAttribute
     * @param MagentoAttributeInterface $magentoAttribute
     */
    public function __construct(
        PimAttributeInterface $pimAttribute,
        MagentoAttributeInterface $magentoAttribute
    ) {
        if ($pimAttribute->getBackendType() !== 'text') {
            throw new InvalidAttributeBackendTypeException(sprintf(
                'The PIM attribute %s\'s backend type mut be "text".',
                $pimAttribute->getCode()
            ));
        }

        if ($magentoAttribute->getBackendType() !== 'text') {
            throw new InvalidAttributeBackendTypeException(sprintf(
                'The Magento attribute %s\'s backend type mut be "text".',
                $magentoAttribute->getCode()
            ));
        }

        $this->pimAttribute = $pimAttribute;
        $this->magentoAttribute = $magentoAttribute;
    }

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
    ) {
        $pimValue = $pimProduct->getValue($this->pimAttribute->getCode());

        if ($magentoProduct->isConfigurable()) {
            $currentAttribute = $this->magentoAttribute;
            $isAxis = $magentoProduct->getAxisAttributes()
                ->exists(function (MagentoAttributeInterface $attribute) use ($currentAttribute) {
                    return $attribute->getId() === $currentAttribute->getId();
                });

            if ($isAxis) {
                return false;
            }
        }

        if ($magentoProduct->hasValueFor($this->magentoAttribute, $storeId)) {
            $magentoValue = $magentoProduct->getValueFor($this->magentoAttribute, $storeId);
            if (!$magentoValue instanceof MutableAttributeValueInterface) {
                throw new ImmutableValueException(sprintf(
                    'The Magento attribute %s\'s value is immutable for product %s.',
                    $this->magentoAttribute->getCode(),
                    $magentoProduct->getIdentifier()->getValue()
                ));
            }

            /** @var MutableTextAttributeValue $magentoValue */
            $magentoValue->setValue($pimValue->getText());
        } else {
            $magentoValue = new ImmutableTextAttributeValue(
                $this->magentoAttribute,
                $pimValue->getText(),
                $storeId
            );

            $magentoProduct->setValue($magentoValue);
        }

        return true;
    }
}