<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductAttributeRepositoryInterface
    extends AttributeRepositoryInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product);

    /**
     * @param ProductInterface $product
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product);

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family);

    /**
     * @param FamilyInterface $family
     *
     * @return \Traversable|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family);
}
