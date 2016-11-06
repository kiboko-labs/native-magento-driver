<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

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
