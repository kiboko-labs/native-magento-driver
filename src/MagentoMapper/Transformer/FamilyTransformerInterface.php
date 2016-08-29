<?php

namespace Kiboko\Component\MagentoMapper\Transformer;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface as KibokoFamilyInterface;
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
