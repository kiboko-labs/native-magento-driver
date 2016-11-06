<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Exception\InvalidProductTypeException;
use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;

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
     * @param AttributeMatcherInterface      $builder
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
