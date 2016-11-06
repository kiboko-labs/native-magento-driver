<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Hydrator;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;

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
