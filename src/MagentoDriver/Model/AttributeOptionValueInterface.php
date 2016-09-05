<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeOptionValueInterface extends LocalizedMappableInterface, IdentifiableInterface
{
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
