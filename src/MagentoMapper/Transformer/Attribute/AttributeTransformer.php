<?php

namespace Kiboko\Component\MagentoMapper\Transformer\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface as KibokoAttributeInterface;
use Pim\Component\Catalog\Model\AttributeInterface as PimAttributeInterface;

class AttributeTransformer
    implements AttributeTransformerInterface
{
    /**
     * @var AttributeMapperInterface
     */
    private $mapper;

    /**
     * @var \Traversable|AttributeTransformerInterface[]
     */
    private $attributeTransformers;

    /**
     * AttributeModelMapper constructor.
     *
     * @param AttributeMapperInterface $mapper
     * @param array                    $attributeTransformers
     */
    public function __construct(
        AttributeMapperInterface $mapper,
        array $attributeTransformers = []
    ) {
        $this->mapper = $mapper;

        $this->setAttributeTransformers($attributeTransformers);
    }

    /**
     * @param \Traversable|AttributeTransformerInterface[] $attributeTransformers
     */
    public function setAttributeTransformers(array $attributeTransformers)
    {
        $this->attributeTransformers = new ArrayCollection();
        foreach ($attributeTransformers as $transformer) {
            if (!$transformer instanceof AttributeTransformerInterface) {
                continue;
            }

            $this->attributeTransformers->add($transformer);
        }
    }

    /**
     * @param AttributeTransformerInterface $attributeTransformer
     */
    public function addAttributeTransformer(AttributeTransformerInterface $attributeTransformer)
    {
        $this->attributeTransformers->add($attributeTransformer);
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return \Traversable|KibokoAttributeInterface[]
     */
    public function transform(PimAttributeInterface $attribute)
    {
        /** @var AttributeTransformerInterface $transformer */
        foreach ($this->attributeTransformers as $transformer) {
            if (!$transformer->supportsTransformation($attribute)) {
                continue;
            }

            $attributes = $transformer->transform($attribute);
            foreach ($attributes as $attribute) {
                if (($attributeId = $this->mapper->map($attribute->getCode())) !== null) {
                    $attribute->persistedToId($attributeId);
                }
            }

            return $attributes;
        }

        return;
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        return $attribute instanceof PimAttributeInterface;
    }
}
