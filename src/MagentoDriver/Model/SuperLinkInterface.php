<?php

namespace Luni\Component\MagentoDriver\Model;

use Luni\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;
use Luni\Component\MagentoDriver\Entity\Product\SimpleProductInterface;

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
     * @return bool
     */
    public function isConfigurable(ConfigurableProductInterface $configurable);

    /**
     * @param SimpleProductInterface $variant
     * @return bool
     */
    public function isVariant(SimpleProductInterface $variant);

    /**
     * @param int $id
     */
    public function persistedToId($id);
}