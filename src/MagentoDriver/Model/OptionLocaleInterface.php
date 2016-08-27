<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface OptionLocaleInterface extends MappableInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return int
     */
    public function getStoreId();
}
