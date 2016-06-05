<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Exception\InvalidProductTypeException;
use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class StandardProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $builders;

    /**
     * MutableProductAttributeValueFactory constructor.
     */
    public function __construct()
    {
        $this->builders = new \SplObjectStorage();
    }

    /**
     * @param AttributeValueFactoryInterface $matcher
     * @param AttributeMatcherInterface $builder
     */
    public function addBuilder(AttributeValueFactoryInterface $matcher, AttributeMatcherInterface $builder)
    {
        $this->builders->attach($matcher, $builder);
    }

    /**
     * @return \Generator|\Closure[]
     */
    public function walkBuildersList()
    {
        /** @var AttributeMatcherInterface $matcher */
        foreach ($this->builders as $matcher) {
            yield $matcher => $this->builders[$matcher];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return AttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        /**
         * @var AttributeMatcherInterface
         * @var AttributeValueFactoryInterface $builder
         */
        foreach ($this->walkBuildersList() as $matcher => $builder) {
            if (!$matcher->match($attribute, $options)) {
                continue;
            }

            return $builder->buildNew($attribute, $options);
        }

        throw new InvalidProductTypeException(sprintf('No attribute value bucket found for attribute "%s"', $attribute->getCode()));
    }
}
