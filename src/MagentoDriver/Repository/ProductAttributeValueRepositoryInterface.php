<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface ProductAttributeValueRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromDefault(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllVariantAxisByProductFromStoreId(ProductInterface $product, $storeId);

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return AttributeValueInterface|null
     */
    public function findOneByProductAndAttributeFromStoreId(
        ProductInterface $product,
        AttributeInterface $attribute,
        $storeId
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface[] $attributeList
     * @return AttributeValueInterface|null
     */
    public function findAllByProductAndAttributeListFromDefault(
        ProductInterface $product,
        array $attributeList
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
     * @return AttributeValueInterface|null
     */
    public function findAllByProductAndAttributeListFromStoreId(
        ProductInterface $product,
        array $attributeList,
        $storeId
    );

    /**
     * @param ProductInterface[] $productList
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListFromDefault(
        array $productList
    );

    /**
     * @param ProductInterface[] $productList
     * @param int $storeId
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListFromStoreId(
        array $productList,
        $storeId
    );

    /**
     * @param ProductInterface[] $productList
     * @param AttributeInterface[] $attributeList
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListAndAttributeListFromDefault(
        array $productList,
        array $attributeList
    );

    /**
     * @param ProductInterface[] $productList
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
     * @return AttributeValueInterface|null
     */
    public function findAllByProductListAndAttributeListFromStoreId(
        array $productList,
        array $attributeList,
        $storeId
    );

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromDefault(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreId(ProductInterface $product, $storeId);
}
