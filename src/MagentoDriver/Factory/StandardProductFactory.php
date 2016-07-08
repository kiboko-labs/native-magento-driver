<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Broker\ProductFactoryBrokerInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Exception\InvalidProductTypeException;

class StandardProductFactory implements ProductFactoryInterface
{
    /**
     * @var ProductFactoryBrokerInterface
     */
    private $broker;

    /**
     * StandardProductFactory constructor.
     * @param ProductFactoryBrokerInterface $broker
     */
    public function __construct(
        ProductFactoryBrokerInterface $broker
    ) {
        $this->broker = $broker;
    }

    /**
     * @param array  $options
     *
     * @return ProductInterface
     */
    public function buildNew(array $options)
    {
        /** @var ProductFactoryInterface $factory */
        if (($factory = $this->broker->findFor($options)) === null) {
            throw new InvalidProductTypeException(sprintf('No factory found for [%s]', implode(', ', $options)));
        }

        return $factory->buildNew($options);
    }
}
