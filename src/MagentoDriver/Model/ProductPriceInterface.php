<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface ProductPriceInterface extends MappableInterface
{
    /**
     * @return float
     */
    public function getFinalAmountInclTax();

    /**
     * @return float
     */
    public function getFinalAmountExclTax();

    /**
     * @return string
     */
    public function getCurrencyCode();
}
