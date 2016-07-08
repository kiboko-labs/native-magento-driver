<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;

interface ConfigurableProductInterface extends ProductInterface
{
    /**
     * @param AttributeInterface $superAttribute
     */
    public function addAxisAttribute(AttributeInterface $superAttribute);

    /**
     * @param \Traversable|AttributeInterface[] $superAttributeList
     */
    public function addAxisAttributeList(\Traversable $superAttributeList);

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
     * @return \Traversable|AttributeInterface[]
     */
    public function getAxisAttributes();

    /**
     * @param SimpleProductInterface $variant
     */
    public function addVariant(SimpleProductInterface $variant);

    /**
     * @param \Traversable|SimpleProductInterface[] $variants
     */
    public function addVariantList(\Traversable $variants);

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
     * @return \Traversable|SimpleProductInterface[]
     */
    public function getVariants();

    /**
     * @param SuperLinkInterface $superLink
     */
    public function addSuperLink(SuperLinkInterface $superLink);

    /**
     * @param \Traversable|SuperLinkInterface[] $superLinks
     */
    public function addSuperLinkList(\Traversable $superLinks);

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
     * @return \Traversable|SuperLinkInterface[]
     */
    public function getSuperLinks();
}
