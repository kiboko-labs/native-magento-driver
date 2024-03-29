<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

trait ImageMetadataAttributeValueTrait
{
    use AttributeValueTrait;
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $position;

    /**
     * @var bool
     */
    private $excluded;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param string             $label
     * @param int                $position
     * @param bool               $excluded
     * @param null               $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        $label,
        $position,
        $excluded = false,
        $storeId = null
    );

    /**
     * @param int                $valueId
     * @param AttributeInterface $attribute
     * @param string             $label
     * @param int                $storeId
     * @param int                $position
     * @param bool               $excluded
     *
     * @return ImageMetadataAttributeValueInterface
     */
    public static function buildNewWith(
        $valueId,
        AttributeInterface $attribute,
        $label,
        $position,
        $excluded = false,
        $storeId = null
    ) {
        $object = new static($attribute, $label, $position, $excluded, $storeId);

        $object->identifier = $valueId;

        return $object;
    }

    /**
     * @return bool
     */
    public function isScopable()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function isExcluded()
    {
        return $this->excluded;
    }
}
