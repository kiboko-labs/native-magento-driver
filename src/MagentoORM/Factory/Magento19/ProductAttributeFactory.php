<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\V1_9ce;

use Kiboko\Component\MagentoORM\Factory\AttributeFactoryInterface;
use Kiboko\Component\MagentoORM\Factory\CatalogAttributeExtensionsFactoryInterface;
use Kiboko\Component\MagentoORM\Factory\ProductAttributeFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\V1_9ce\CatalogAttribute;

class ProductAttributeFactory implements ProductAttributeFactoryInterface
{
    /**
     * @var AttributeFactoryInterface
     */
    private $attributeFactory;

    /**
     * @var CatalogAttributeExtensionsFactoryInterface
     */
    private $catalogattributeExtensionsFactory;

    /**
     * @param AttributeFactoryInterface                  $attributeFactory
     * @param CatalogAttributeExtensionsFactoryInterface $catalogattributeExtensionsFactory
     */
    public function __construct(
        AttributeFactoryInterface $attributeFactory,
        CatalogAttributeExtensionsFactoryInterface $catalogattributeExtensionsFactory
    ) {
        $this->attributeFactory = $attributeFactory;
        $this->catalogattributeExtensionsFactory = $catalogattributeExtensionsFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeInterface|CatalogAttributeExtensionInterface
     */
    public function buildNew(array $options)
    {
        return new CatalogAttribute(
            $this->attributeFactory->buildNew($options),
            $this->catalogattributeExtensionsFactory->buildNew($options)
        );
    }
}
