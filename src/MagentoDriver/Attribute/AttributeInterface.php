<?php

namespace Luni\Component\MagentoDriver\Attribute;

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
     * @return string
     */
    public function getFrontendType();

    /**
     * @param string $key
     * @return string
     */
    public function getOption($key);

    /**
     * @return array
     */
    public function getOptions();
}