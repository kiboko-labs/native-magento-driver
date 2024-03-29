<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

interface ProductAttributeRepositoryInterface extends AttributeRepositoryInterface
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
