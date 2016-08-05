<?php

namespace Kiboko\Component\MagentoMapper\Transformer\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface;
use Pim\Component\Catalog\Model\AttributeInterface;

class AttributeTransformer
    implements AttributeTransformerInterface
{
    /**
     * @var AttributeMapperInterface
     */
    private $mapper;

    /**
     * @var Collection|AttributeTransformerInterface[]
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
     * @param Collection|AttributeTransformerInterface[] $attributeTransformers
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
     * @param AttributeInterface $attribute
     *
     * @return \Kiboko\Component\MagentoDriver\Model\AttributeInterface|null
     */
    public function transform(AttributeInterface $attribute)
    {
        /** @var AttributeTransformerInterface $transformer */
        foreach ($this->attributeTransformers as $transformer) {
            if (!$transformer->supportsTransformation($attribute)) {
                continue;
            }

            $attribute = $transformer->transform($attribute);
            if (($attributeId = $this->mapper->map($attribute->getCode())) !== null) {
                $attribute->persistedToId($attributeId);
            }

            return $attribute;
        }

        return;
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(AttributeInterface $attribute)
    {
        return $attribute instanceof AttributeInterface;
    }
}
