<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Model\FamilyInterface as KibokoFamilyInterface;
use Pim\Component\Catalog\Model\FamilyInterface as PimFamilyInterface;

interface FamilyTransformerInterface
{
    /**
     * @param PimFamilyInterface $family
     *
     * @return KibokoFamilyInterface[]|\Traversable
     */
    public function transform(PimFamilyInterface $family);

    /**
     * @param PimFamilyInterface $family
     *
     * @return bool
     */
    public function supportsTransformation(PimFamilyInterface $family);
}
