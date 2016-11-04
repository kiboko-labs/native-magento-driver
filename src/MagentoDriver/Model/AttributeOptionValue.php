<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeOptionValue implements AttributeOptionValueInterface
{
    use LocalizedMappableTrait;
    use IdentifiableTrait;

    /**
     * @var int
     */
    private $optionId;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var string
     */
    private $value;

    /**
     * @param int $optionId
     * @param int $storeId
     * @param string $value
     */
    public function __construct($optionId, $storeId, $value)
    {
        $this->optionId = $optionId;
        $this->storeId = $storeId;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int    $attributeOptionValueId
     * @param int    $optionId
     * @param int    $storeId
     * @param string $value
     *
     * @return AttributeOptionValueInterface
     */
    public static function buildNewWith(
        $attributeOptionValueId,
        $optionId,
        $storeId,
        $value = null
    ) {
        $object = new static($optionId, $storeId, $value);

        $object->persistedToId($attributeOptionValueId);

        return $object;
    }
}
