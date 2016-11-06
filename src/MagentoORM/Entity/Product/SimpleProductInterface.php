<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Entity\Product;

use Kiboko\Component\MagentoORM\Model\SuperLinkInterface;

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
     * @return \Traversable|ConfigurableProductInterface[]
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
