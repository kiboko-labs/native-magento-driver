<?php

namespace Luni\Component\MagentoDriver\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidProductTypeException;

class StandardProductFactory
    implements ProductFactoryInterface
{
    /**
     * @var Collection
     */
    private $builders;

    public function __construct()
    {
        $this->builders = new ArrayCollection();
    }

    public function addBuilder($type, \Closure $callback)
    {
        $this->builders->set($type, $callback);
    }

    /**
     * @param string $type
     * @param array $options
     * @return ProductInterface
     */
    public function buildNew($type, array $options)
    {
        /**
         * @var string $expectedType
         * @var \Closure $builder
         */
        foreach ($this->builders as $expectedType => $builder) {
            if ($expectedType !== $type) {
                continue;
            }

            return $builder($type, $options);
        }

        throw new InvalidProductTypeException(sprintf('No type builder found for type "%s"', $type));
    }
}
