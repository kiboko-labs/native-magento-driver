<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Entity\Product;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\SuperLinkInterface;

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
