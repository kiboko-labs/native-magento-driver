<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeOptionInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @param AttributeOptionValueInterface $optionValue
     */
    public function addValue(AttributeOptionValueInterface $optionValue);

    /**
     * @param AttributeOptionValueInterface[] $optionValues
     */
    public function setValues(array $optionValues);

    /**
     * @return AttributeOptionValueInterface[]
     */
    public function getValues();
}
