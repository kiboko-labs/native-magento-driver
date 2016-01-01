<?php

namespace Luni\Component\MagentoDriver\Hydrator;

use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

interface ProductAttributeValueHydratorInterface
{
    /**
     * @param ProductInterface $product
     * @param int $storeId
     */
    public function hydrate(ProductInterface $product, $storeId = null);

    /**
     * @param ProductInterface $product
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
     */
    public function hydrateByAttributeList(ProductInterface $product, array $attributeList, $storeId = null);
}