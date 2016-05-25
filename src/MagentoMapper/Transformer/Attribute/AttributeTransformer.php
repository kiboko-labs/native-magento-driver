<?php

namespace Kiboko\Component\MagentoTransformer\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoMapper\Transformer\AttributeTransformerInterface;
use Kiboko\Component\MagentoMapper\Mapper\AttributeMapperInterface as RemoteAttributeMapperInterface;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface;

class AttributeTransformer
    implements AttributeTransformerInterface
{
    /**
     * @var RemoteAttributeMapperInterface
     */
    private $mapper;

    /**
     * @var Collection|AttributeTransformerInterface[]
     */
    private $attributeTransformers;

    /**
     * AttributeModelMapper constructor.
     *
     * @param RemoteAttributeMapperInterface $mapper
     * @param array                          $attributeTransformers
     */
    public function __construct(
        RemoteAttributeMapperInterface $mapper,
        array $attributeTransformers = []
    ) {
        $this->mapper = $mapper;

        $this->attributeTransformers = new ArrayCollection();
        foreach ($attributeTransformers as $transformer) {
            if (!$transformer instanceof AttributeTransformerInterface) {
                continue;
            }

            $this->attributeTransformers->add($transformer);
        }
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
