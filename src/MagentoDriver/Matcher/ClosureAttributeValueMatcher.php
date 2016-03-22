<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

class ClosureAttributeValueMatcher implements AttributeValueMatcherInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @var AttributeValueMatcherInterface
     */
    private $next;

    /**
     * @param \Closure                            $matcher
     * @param AttributeValueMatcherInterface|null $next
     */
    public function __construct(\Closure $matcher, AttributeValueMatcherInterface $next = null)
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
