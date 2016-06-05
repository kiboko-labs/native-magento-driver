<?php

namespace Kiboko\Component\MagentoDriver\Matcher\AttributeValue;

use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

class ClosureAttributeValueMatcher implements AttributeMatcherInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @var AttributeMatcherInterface
     */
    private $next;

    /**
     * @param \Closure                       $matcher
     * @param AttributeMatcherInterface|null $next
     */
    public function __construct(\Closure $matcher, AttributeMatcherInterface $next = null)
    {
        $this->closure = $matcher;
    }

    /**
     * @param AttributeInterface $attributeValue
     *
     * @return bool
     */
    public function match(AttributeInterface $attributeValue)
    {
        $closure = $this->closure;
        if ($closure($attributeValue) !== true) {
            return false;
        }

        if ($this->next === null) {
            return true;
        }

        return $this->next->match($attributeValue);
    }
}
