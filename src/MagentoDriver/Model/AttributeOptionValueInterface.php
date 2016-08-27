<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeOptionValueInterface extends LocalizedMappableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getOptionId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getValue();
}
