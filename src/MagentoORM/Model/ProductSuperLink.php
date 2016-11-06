<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Entity\Product\ConfigurableProductInterface;
use Kiboko\Component\MagentoORM\Entity\Product\SimpleProductInterface;

class ProductSuperLink implements SuperLinkInterface
{
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var ConfigurableProductInterface
     */
    private $configurable;

    /**
     * @var SimpleProductInterface
     */
    private $variant;

    /**
     * @param ConfigurableProductInterface $configurable
     * @param SimpleProductInterface       $variant
     */
    public function __construct(
        ConfigurableProductInterface $configurable,
        SimpleProductInterface $variant
    ) {
        $this->configurable = $configurable;
        $this->variant = $variant;
    }

    /**
     * @param int                          $identifier
     * @param ConfigurableProductInterface $configurable
     * @param SimpleProductInterface       $variant
     *
     * @return static
     */
    public static function buildNewWith(
        $identifier,
        ConfigurableProductInterface $configurable,
        SimpleProductInterface $variant
    ) {
        $instance = new self($configurable, $variant);

        $instance->persistedToId($identifier);

        return $instance;
    }

    /**
     * @return int
     */
    public function getConfigurableId()
    {
        return $this->configurable->getId();
    }

    /**
     * @return int
     */
    public function getVariantId()
    {
        return $this->variant->getId();
    }

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function isConfigurable(ConfigurableProductInterface $configurable)
    {
        return $this->configurable === $configurable;
    }

    /**
     * @param SimpleProductInterface $variant
     *
     * @return bool
     */
    public function isVariant(SimpleProductInterface $variant)
    {
        return $this->variant === $variant;
    }
}
