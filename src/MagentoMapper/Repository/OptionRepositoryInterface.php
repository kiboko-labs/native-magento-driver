<?php

namespace Luni\Component\MagentoMapper\Repository;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface OptionRepositoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param $optionCode
     * @return int
     */
    public function findOneByAttribute(AttributeInterface $attribute, $optionCode);

    /**
     * @param AttributeInterface $attribute
     * @return int[]
     */
    public function findAllByAttribute(AttributeInterface $attribute);
}