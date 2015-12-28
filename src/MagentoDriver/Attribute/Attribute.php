<?php

namespace Luni\Component\MagentoDriver\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Luni\Component\MagentoDriver\AttributeBackend\BackendInterface;

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
     * @var BackendInterface
     */
    private $backend;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $code
     * @param BackendInterface $backend
     * @param array $options
     */
    public function __construct(
        $code,
        BackendInterface $backend,
        array $options = []
    ) {
        $this->code = $code;
        $this->backend = $backend;
        $this->options = new ArrayCollection($options);
    }

    /**
     * @param int $attributeId
     * @param string $code
     * @param BackendInterface $backend
     * @param array $options
     * @return AttributeInterface
     */
    public static function buildNewWith(
        $attributeId,
        $code,
        BackendInterface $backend,
        array $options = []
    ) {
        $object = new static($code, $backend, $options);

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
        return $this->backend->getType();
    }

    /**
     * @return BackendInterface
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getOption($key)
    {
        return $this->options->get($key);
    }
}