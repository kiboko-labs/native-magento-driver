<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Broker\ProductFactoryBrokerInterface;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Exception\InvalidProductTypeException;

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
