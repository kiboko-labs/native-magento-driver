<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

trait ImageAttributeValueTrait
{
    use AttributeValueTrait;

    /**
     * @var \SplFileInfo
     */
    private $file;

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
     * @param AttributeInterface $attribute
     * @param \SplFileInfo $file
     * @param string $label
     * @param int $position
     * @param bool $excluded
     * @param null $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        \SplFileInfo $payload,
        $label,
        $position,
        $excluded = false,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int $valueId
     * @param \SplFileInfo $file
     * @param string $label
     * @param int $storeId
     * @param int $position
     * @param bool $excluded
     * @return ImageAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        \SplFileInfo $file,
        $label,
        $position,
        $excluded = false,
        $storeId = null
    ) {
        $object = new static($attribute, $file, $label, $position, $excluded, $storeId);

        $object->id = $valueId;

        return $object;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
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
        $this->position;
    }

    /**
     * @return bool
     */
    public function isExcluded()
    {
        return $this->excluded;
    }
}