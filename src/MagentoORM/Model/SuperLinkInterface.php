<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Entity\Product\ConfigurableProductInterface;
use Kiboko\Component\MagentoORM\Entity\Product\SimpleProductInterface;

interface SuperLinkInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getConfigurableId();

    /**
     * @return int
     */
    public function getVariantId();

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function isConfigurable(ConfigurableProductInterface $configurable);

    /**
     * @param SimpleProductInterface $variant
     *
     * @return bool
     */
    public function isVariant(SimpleProductInterface $variant);
}
