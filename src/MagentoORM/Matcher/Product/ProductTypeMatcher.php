<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Matcher\Product;

use Kiboko\Component\MagentoORM\Matcher\ProductDataMatcherInterface;

class ProductTypeMatcher implements ProductDataMatcherInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var ProductDataMatcherInterface
     */
    private $next;

    /**
     * @param string                           $expectedType
     * @param ProductDataMatcherInterface|null $next
     */
    public function __construct($expectedType, ProductDataMatcherInterface $next = null)
    {
        $this->expectedType = $expectedType;
        $this->next = $next;
    }

    /**
     * @param array $productData
     *
     * @return bool
     */
    public function match(array $productData)
    {
        if (!isset($productData['type_id']) || $this->expectedType !== $productData['type_id']) {
            return false;
        }

        if ($this->next === null) {
            return true;
        }

        return $this->next->match($productData);
    }
}
