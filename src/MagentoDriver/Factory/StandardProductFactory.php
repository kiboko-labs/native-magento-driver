<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Entity\Product\SimpleProduct;
use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProduct;
use Kiboko\Component\MagentoDriver\Model\Family;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Exception\InvalidProductTypeException;

class StandardProductFactory implements ProductFactoryInterface
{
    /**
     * @var Collection
     */
    private $builders;

    public function __construct()
    {
        $this->builders = new ArrayCollection();
        $this->addBuilder(
            'simple',
            function ($type, $options) {
                return SimpleProduct::buildNewWith(
                    $options['entity_id'],
                    $options['sku'],
                    Family::buildNewWith(
                        $options['attribute_set_id'],
                        // $options['attribute_set_name']
                        // $label
                        /* @todo: this section must be review */
                        ucfirst($type).'AttributeSet'
                    ),
                    new \DateTime($options['created_at']),
                    new \DateTime($options['updated_at'])
                );
            }
        );
        $this->addBuilder(
            'configurable',
            function ($type, $options) {
                return ConfigurableProduct::buildNewWith(
                    $options['entity_id'],
                    $options['sku'],
                    Family::buildNewWith(
                        $options['attribute_set_id'],
                        ucfirst($type).'AttributeSet' /* // $options['attribute_set_name'] // $label */ /* @todo: this section must be review */
                    ),
                    new \DateTime($options['created_at']),
                    new \DateTime($options['updated_at'])
                );
            }
        );
    }

    public function addBuilder($type, \Closure $callback)
    {
        $this->builders->set($type, $callback);
    }

    /**
     * @param string $type
     * @param array  $options
     *
     * @return ProductInterface
     */
    public function buildNew($type, array $options)
    {
        /**
         * @var string
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
