<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\SimpleProductInterface;

interface SuperLinkInterface
{
    /**
     * @return int
     */
    public function getId();

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

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier);
}
