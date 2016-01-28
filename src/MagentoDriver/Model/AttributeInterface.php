<?php

namespace Luni\Component\MagentoDriver\Model;

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
     * @return string|int|null
     */
    public function getOption($key);

    /**
     * @param string $key
     * @param string|int|null $default
     * @return string|int|null
     */
    public function getOptionOrDefault($key, $default = null);

    /**
     * @return array
     */
    public function getOptions();
}