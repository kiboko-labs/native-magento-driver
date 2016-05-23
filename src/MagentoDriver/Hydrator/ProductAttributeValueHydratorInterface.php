<?php

namespace Kiboko\Component\MagentoDriver\Hydrator;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface ProductAttributeValueHydratorInterface
{
    /**
     * @param ProductInterface $product
     * @param int              $storeId
     */
    public function hydrate(ProductInterface $product, $storeId = null);

    /**
     * @param ProductInterface     $product
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     */
    public function hydrateByAttributeList(ProductInterface $product, array $attributeList, $storeId = null);

    /**
     * @param ProductInterface[] $productList
     * @param int                $storeId
     */
    public function hydrateList(array $productList, $storeId = null);

    /**
     * @param ProductInterface[]   $productList
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     */
    public function hydrateListByAttributeList(array $productList, array $attributeList, $storeId = null);
}
