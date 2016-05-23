<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductAttributeRepositoryInterface extends AttributeRepositoryInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product);

    /**
     * @param ProductInterface $product
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product);

    /**
     * @param FamilyInterface $family
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family);

    /**
     * @param FamilyInterface $family
     *
     * @return Collection|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family);
}
