<?php

namespace Kiboko\Component\MagentoMapper\Mapper;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoMapper\Repository\OptionRepositoryInterface;

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
