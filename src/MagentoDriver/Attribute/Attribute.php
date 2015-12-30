<?php

namespace Luni\Component\MagentoDriver\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Luni\Component\MagentoDriver\Backend\AttributeValue\BackendInterface;

class Attribute
    implements AttributeInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $backendType;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $code
     * @param string $backendType
     * @param array $options
     */
    public function __construct(
        $code,
        $backendType,
        array $options = []
    ) {
        $this->code = $code;
        $this->backendType = $backendType;
        $this->options = new ArrayCollection($options);
    }

    /**
     * @param int $attributeId
     * @param string $code
     * @param string $backendType
     * @param array $options
     * @return AttributeInterface
     */
    public static function buildNewWith(
        $attributeId,
        $code,
        $backendType,
        array $options = []
    ) {
        $object = new static($code, $backendType, $options);

        $object->id = $attributeId;

        return $object;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getBackendType()
    {
        return $this->backendType;
    }

    /**
     * @return string
     */
    public function getFrontendType()
    {
        return $this->getOption('frontend_input');
    }

    /**
     * @param string $key
     * @return string
     */
    public function getOption($key)
    {
        return $this->options->get($key);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}