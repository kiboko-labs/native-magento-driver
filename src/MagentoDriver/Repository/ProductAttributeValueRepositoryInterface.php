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
    public function findAllByProductAndAttributeFromDefault(
        ProductInterface $product,
        array $attributeList
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface[] $attributeList
     * @param int $storeId
     * @return AttributeValueInterface|null
     */
    public function findAllByProductAndAttributeFromStoreId(
        ProductInterface $product,
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