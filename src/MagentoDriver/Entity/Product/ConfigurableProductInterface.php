<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;

interface ConfigurableProductInterface extends ProductInterface
{
    /**
     * @param AttributeInterface $superAttribute
     */
    public function addAxisAttribute(AttributeInterface $superAttribute);

    /**
     * @param Collection|AttributeInterface[] $superAttributeList
     */
    public function addAxisAttributeList(Collection $superAttributeList);

    /**
     * @param AttributeInterface $attribute
     *
     * @return bool
     */
    public function hasAxisAttribute(AttributeInterface $attribute);

    /**
     * @return bool
     */
    public function hasAxisAttributes();

    /**
     * @return Collection|AttributeInterface[]
     */
    public function getAxisAttributes();

    /**
     * @param SimpleProductInterface $variant
     */
    public function addVariant(SimpleProductInterface $variant);

    /**
     * @param Collection|SimpleProductInterface[] $variants
     */
    public function addVariantList(Collection $variants);

    /**
     * @param SimpleProductInterface $variant
     *
     * @return bool
     */
    public function hasVariant(SimpleProductInterface $variant);

    /**
     * @return bool
     */
    public function hasVariants();

    /**
     * @return Collection|SimpleProductInterface[]
     */
    public function getVariants();

    /**
     * @param SuperLinkInterface $superLink
     */
    public function addSuperLink(SuperLinkInterface $superLink);

    /**
     * @param Collection|SuperLinkInterface[] $superLinks
     */
    public function addSuperLinkList(Collection $superLinks);

    /**
     * @param SuperLinkInterface $superLink
     *
     * @return bool
     */
    public function hasSuperLink(SuperLinkInterface $superLink);

    /**
     * @return bool
     */
    public function hasSuperLinks();

    /**
     * @return Collection|SuperLinkInterface[]
     */
    public function getSuperLinks();
}
