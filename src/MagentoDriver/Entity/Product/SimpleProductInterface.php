<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;

interface SimpleProductInterface extends ProductInterface
{
    /**
     * @param ConfigurableProductInterface $configurable
     * @param SuperLinkInterface           $superLink
     */
    public function addToConfigurable(
        ConfigurableProductInterface $configurable,
        SuperLinkInterface $superLink
    );

    /**
     * @return Collection|ConfigurableProductInterface[]
     */
    public function getConfigurables();

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function hasConfigurable(ConfigurableProductInterface $configurable);

    /**
     * @return bool
     */
    public function hasConfigurables();
}
