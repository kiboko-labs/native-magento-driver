<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

class ProductPrice implements ProductPriceInterface
{
    use AttributeValueTrait;
    use MappableTrait;

    /**
     * @var float
     */
    private $finalAmountInclTax;

    /**
     * @var float
     */
    private $finalAmountExclTax;

    /**
     * @var float
     */
    private $originalAmountInclTax;

    /**
     * @var float
     */
    private $originalAmountExclTax;

    /**
     * @var float
     */
    private $discountAmountInclTax;

    /**
     * @var float
     */
    private $discountAmountExclTax;

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $regionCode;

    /**
     * @return float
     */
    public function getFinalAmountInclTax()
    {
        return $this->finalAmountInclTax;
    }

    /**
     * @return float
     */
    public function getFinalAmountExclTax()
    {
        return $this->finalAmountExclTax;
    }

    /**
     * @return float
     */
    public function getOriginalAmountInclTax()
    {
        return $this->originalAmountInclTax;
    }

    /**
     * @return float
     */
    public function getOriginalAmountExclTax()
    {
        return $this->originalAmountExclTax;
    }

    /**
     * @return float
     */
    public function getDiscountAmountInclTax()
    {
        return $this->discountAmountInclTax;
    }

    /**
     * @return float
     */
    public function getDiscountAmountExclTax()
    {
        return $this->discountAmountExclTax;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * @param float $finalAmountInclTax
     */
    public function setFinalAmountInclTax($finalAmountInclTax)
    {
        $this->finalAmountInclTax = $finalAmountInclTax;
    }

    /**
     * @param float $originalAmountInclTax
     */
    public function setOriginalAmountInclTax($originalAmountInclTax)
    {
        $this->originalAmountInclTax = $originalAmountInclTax;
    }

    /**
     * @param float $originalAmountExclTax
     */
    public function setOriginalAmountExclTax($originalAmountExclTax)
    {
        $this->originalAmountExclTax = $originalAmountExclTax;
    }

    /**
     * @param float $discountAmountInclTax
     */
    public function setDiscountAmountInclTax($discountAmountInclTax)
    {
        $this->discountAmountInclTax = $discountAmountInclTax;
    }

    /**
     * @param float $discountAmountExclTax
     */
    public function setDiscountAmountExclTax($discountAmountExclTax)
    {
        $this->discountAmountExclTax = $discountAmountExclTax;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @param string $regionCode
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;
    }

    /**
     * @return bool
     */
    public function isScopable()
    {
        return true;
    }
}
