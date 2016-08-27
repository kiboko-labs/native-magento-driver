<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeOption implements AttributeOptionInterface
{
    use MappableTrait;

    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $attributeId;

    /**
     * @var int
     */
    private $sortOrder;

    /**
     * @var int
     */
    private $values;

    /**
     * @param int $attributeId
     * @param int $sortOrder
     * @param array $values
     */
    public function __construct($attributeId, $sortOrder, array $values = null)
    {
        $this->attributeId = $attributeId;
        $this->sortOrder = $sortOrder;

        if ($values !== null) {
            $this->setValues($values);
        } else {
            $this->values = [];
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $attributeOptionId
     * @param int $attributeId
     * @param int $sortOrder
     *
     * @return AttributeOptionInterface
     */
    public static function buildNewWith(
        $attributeOptionId,
        $attributeId, 
        $sortOrder
    ) {
        $object = new static($attributeId, $sortOrder);

        $object->identifier = $attributeOptionId;

        return $object;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param AttributeOptionValueInterface $optionValue
     */
    public function addValue(AttributeOptionValueInterface $optionValue)
    {
        $this->values[] = $optionValue;
    }

    /**
     * @param AttributeOptionValueInterface[] $optionValues
     */
    public function setValues(array $optionValues)
    {
        $this->values = $optionValues;
    }

    /**
     * @return AttributeOptionValueInterface[]
     */
    public function getValues()
    {
        return $this->values;
    }
}
