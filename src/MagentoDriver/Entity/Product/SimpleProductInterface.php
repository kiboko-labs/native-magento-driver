<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

interface SimpleProductInterface
    extends ProductInterface
{
    /**
     * @param ConfigurableProductInterface $configurable
     */
    public function addToConfigurable(ConfigurableProductInterface $configurable);

    /**
     * @return ConfigurableProductInterface
     */
    public function getConfigurable();

    /**
     * @return bool
     */
    public function hasConfigurable();
}