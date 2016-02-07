<?php

namespace Luni\Component\MagentoDriver\Factory;

use Closure;
use Luni\Component\MagentoDriver\Exception\InvalidProductTypeException;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

class StandardProductAttributeValueFactory
    implements ProductAttributeValueFactoryInterface
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
     * @param Closure $matcher
     * @param Closure $builder
     */
    public function addBuilder(Closure $matcher, Closure $builder)
    {
        $this->builders->attach($matcher, $builder);
    }

    /**
     * @return \Generator|\Closure[]
     */
    public function walkBuildersList()
    {
        foreach ($this->builders as $matcher) {
            yield $matcher => $this->builders[$matcher];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @param array $options
     * @return AttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        /**
         * @var \Closure $matcher
         * @var \Closure $builder
         */
        foreach ($this->walkBuildersList() as $matcher => $builder) {
            if (!$matcher($attribute, $options)) {
                continue;
            }

            return $builder($attribute, $options);
        }

        throw new InvalidProductTypeException(sprintf('No attribute value bucket found for attribute "%s"', $attribute->getCode()));
    }
}
