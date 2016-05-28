<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface OptionLocaleInterface
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
