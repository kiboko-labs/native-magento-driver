<?php

namespace Kiboko\Component\MagentoMapper\Transformer\Attribute;

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
     * @var string
     */
    private $adminLocaleCode;

    /**
     * @var \Traversable|AttributeTransformerInterface[]
     */
    private $attributeTransformers;

    /**
     * AttributeModelMapper constructor.
     *
     * @param AttributeMapperInterface        $mapper
     * @param string                          $adminLocaleCode
     * @param AttributeTransformerInterface[] $attributeTransformers
     */
    public function __construct(
        AttributeMapperInterface $mapper,
        $adminLocaleCode,
        array $attributeTransformers = []
    ) {
        $this->mapper = $mapper;
        $this->adminLocaleCode = $adminLocaleCode;

        $this->setAttributeTransformers($attributeTransformers);
    }

    /**
     * @param \Traversable|AttributeTransformerInterface[] $attributeTransformers
     */
    public function setAttributeTransformers(array $attributeTransformers)
    {
        $this->attributeTransformers = [];
        foreach ($attributeTransformers as $transformer) {
            if (!$transformer instanceof AttributeTransformerInterface) {
                continue;
            }

            $this->attributeTransformers[] = $transformer;
        }
    }

    /**
     * @param AttributeTransformerInterface $attributeTransformer
     */
    public function addAttributeTransformer(AttributeTransformerInterface $attributeTransformer)
    {
        $this->attributeTransformers[] = $attributeTransformer;
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

            $attribute->setLocale($this->adminLocaleCode);

            foreach ($transformer->transform($attribute) as $transformedAttribute) {
                if (($attributeId = $this->mapper->map($attribute->getCode())) !== null) {
                    $transformedAttribute->persistedToId($attributeId);
                }

                $transformedAttribute->setMappingCode($attribute->getCode());

                yield $transformedAttribute;
            }
        }
    }

    /**
     * @param PimAttributeInterface $attribute
     *
     * @return bool
     */
    public function supportsTransformation(PimAttributeInterface $attribute)
    {
        foreach ($this->attributeTransformers as $transformer) {
            if ($transformer->supportsTransformation($attribute)) {
                return true;
            }
        }

        return false;
    }
}
