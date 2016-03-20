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
     * @param int $attributeId
     * @param $optionCode
     * @return int
     */
    public function findOneByAttributeId($attributeId, $optionCode);

    /**
     * @param string $attributeCode
     * @param $optionCode
     * @return int
     */
    public function findOneByAttributeCode($attributeCode, $optionCode);

    /**
     * @param AttributeInterface $attribute
     * @return int[]
     */
    public function findAllByAttribute(AttributeInterface $attribute);
}