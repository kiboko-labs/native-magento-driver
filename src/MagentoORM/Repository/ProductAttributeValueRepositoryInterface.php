<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

interface ProductAttributeValueRepositoryInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromDefault(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromStoreId(ProductInterface $product, $storeId);

    /**
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     *
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    );

    /**
     * @param ProductInterface   $product
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromStoreId(
        ProductInterface $product,
        AttributeInterface $attribute,
        $storeId
    );

    /**
     * @param ProductInterface     $product
     * @param AttributeInterface[] $attributeList
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductAndAttributeListFromDefault(
        ProductInterface $product,
        array $attributeList
    );

    /**
     * @param ProductInterface     $product
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductAndAttributeListFromStoreId(
        ProductInterface $product,
        array $attributeList,
        $storeId
    );

    /**
     * @param ProductInterface[] $productList
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListFromDefault(
        array $productList
    );

    /**
     * @param ProductInterface[] $productList
     * @param int                $storeId
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListFromStoreId(
        array $productList,
        $storeId
    );

    /**
     * @param ProductInterface[]   $productList
     * @param AttributeInterface[] $attributeList
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListAndAttributeListFromDefault(
        array $productList,
        array $attributeList
    );

    /**
     * @param ProductInterface[]   $productList
     * @param AttributeInterface[] $attributeList
     * @param int                  $storeId
     *
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListAndAttributeListFromStoreId(
        array $productList,
        array $attributeList,
        $storeId
    );

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return \Traversable|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId);
}
