<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface ConfigurableProductInterface
    extends ProductInterface
{
    /**
     * @param AttributeInterface $attribute
     */
    public function addAxisAttribute(AttributeInterface $attribute);

    /**
     * @param Collection|AttributeInterface[] $attributeList
     */
    public function addAxisAttributeList(Collection $attributeList);

    /**
     * @param SimpleProductInterface $variant
     */
    public function addVariant(SimpleProductInterface $variant);

    /**
     * @param Collection|SimpleProductInterface[] $variants
     */
    public function addVariants(Collection $variants);

    /**
     * @return bool
     */
    public function hasVariants();

    /**
     * @return Collection|SimpleProductInterface[]
     */
    public function getVariants();
}