<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Transformer\Family;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface as KibokoFamilyInterface;
use Kiboko\Component\MagentoDriver\Model\Family;
use Kiboko\Component\MagentoMapper\Mapper\FamilyMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\FamilyTransformerInterface;
use Pim\Component\Catalog\Model\FamilyInterface as PimFamilyInterface;

class FamilyTransformer implements FamilyTransformerInterface
{
    /**
     * @var FamilyMapperInterface
     */
    private $familyMapper;

    /**
     * FamilyOptionTransformer constructor.
     *
     * @param FamilyMapperInterface $familyMapper
     */
    public function __construct(
        FamilyMapperInterface $familyMapper
    ) {
        $this->familyMapper = $familyMapper;
    }

    /**
     * @param PimFamilyInterface $family
     *
     * @return KibokoFamilyInterface[]|\Traversable
     */
    public function transform(PimFamilyInterface $family)
    {
        $kibokoFamily = Family::buildNewWith(
            $this->familyMapper->map($family->getCode()),
            $family->getLabel()
        );

        $kibokoFamily->setMappingCode($family->getCode());

        yield $kibokoFamily;
    }

    /**
     * @param PimFamilyInterface $family
     *
     * @return bool
     */
    public function supportsTransformation(PimFamilyInterface $family)
    {
        return true;
    }
}
