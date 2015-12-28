<?php

namespace Luni\Component\MagentoDriver\Entity\Updater\Magento\Product;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface as MagentoAttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\Entity\ProductInterface as MagentoProductInterface;
use Luni\Component\MagentoDriver\Entity\Updater\MagentoProductUpdaterInterface;
use Luni\Component\MagentoDriver\Exception\ImmutableValueException;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface as PimAttributeInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface as PimProductInterface;

class ProductVarcharAttributeUpdater
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
        if ($pimAttribute->getBackendType() !== 'varchar') {
            throw new InvalidAttributeBackendTypeException(sprintf(
                'The PIM attribute %s\'s backend type mut be "varchar".',
                $pimAttribute->getCode()
            ));
        }

        if ($magentoAttribute->getBackendType() !== 'varchar') {
            throw new InvalidAttributeBackendTypeException(sprintf(
                'The Magento attribute %s\'s backend type mut be "varchar".',
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

            /** @var MutableVarcharAttributeValue $magentoValue */
            $magentoValue->setValue($pimValue->getVarchar());
        } else {
            $magentoValue = new ImmutableVarcharAttributeValue(
                $this->magentoAttribute,
                $pimValue->getVarchar(),
                $storeId
            );

            $magentoProduct->setValue($magentoValue);
        }

        return true;
    }
}