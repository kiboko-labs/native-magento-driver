<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface ProductPriceInterface
{
    /**
     * @return float
     */
    public function getFinalAmount();

    /**
     * @return string
     */
    public function getCurrencyCode();
}