<?php

namespace Luni\Component\MagentoDriver\Attribute;

use Luni\Component\MagentoDriver\Backend\Attribute\BackendInterface;

interface AttributeInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getBackendType();

    /**
     * @return BackendInterface
     */
    public function getBackend();

    /**
     * @param string $key
     * @return string
     */
    public function getOption($key);
}