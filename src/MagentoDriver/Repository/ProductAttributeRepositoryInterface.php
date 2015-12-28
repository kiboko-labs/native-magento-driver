<?php

namespace Luni\Component\MagentoDriver\Repository;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Family\FamilyInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface ProductAttributeRepositoryInterface
    extends AttributeRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllByEntity(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @return Collection|AttributeInterface[]
     */
    public function findAllVariantAxisByEntity(ProductInterface $product);

    /**
     * @param FamilyInterface $family
     * @return Collection|AttributeInterface[]
     */
    public function findAllByFamily(FamilyInterface $family);

    /**
     * @param FamilyInterface $family
     * @return Collection|AttributeInterface[]
     */
    public function findAllMandatoryByFamily(FamilyInterface $family);
}