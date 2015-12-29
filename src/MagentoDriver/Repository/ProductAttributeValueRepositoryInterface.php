<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface ProductAttributeValueRepositoryInterface
    extends AttributeRepositoryInterface
{
    /**
     * @param int $valueId
     * @return AttributeValueInterface
     */
    public function findOneById($valueId);

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllByProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllVariantAxisByProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllMandatoryByProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromDefault(
        ProductInterface $product,
        AttributeInterface $attribute
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromStoreId(
        ProductInterface $product,
        AttributeInterface $attribute,
        $storeId
    );

    /**
     * @param ProductInterface $product
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return AttributeValueInterface
     */
    public function findOneByProductAndAttributeFromStoreIdOrDefault(
        ProductInterface $product,
        AttributeInterface $attribute,
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

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return Collection|AttributeValueInterface[]
     */
    public function findAllByProductFromStoreIdOrDefault(ProductInterface $product, $storeId);
}