<?php

namespace Luni\Component\MagentoMapper\Mapper;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoMapper\Repository\OptionRepositoryInterface;

class EnhancedOptionMapper extends DefaultOptionMapper
{
    /**
     * EnhancedOptionMapper constructor.
     *
     * @param AttributeInterface        $attribute
     * @param OptionRepositoryInterface $optionRepository
     */
    public function __construct(
        AttributeInterface $attribute,
        OptionRepositoryInterface $optionRepository
    ) {
        parent::__construct($optionRepository->findAllByAttribute($attribute));
    }
}
