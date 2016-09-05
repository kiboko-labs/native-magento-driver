<?php

namespace Kiboko\Component\MagentoDriver\Model;

trait MediaGalleryAttributeValueTrait
{
    use AttributeValueTrait;
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var \Traversable|ImageAttributeValueInterface[]
     */
    private $imagesCollection;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface                        $attribute
     * @param \Traversable|ImageAttributeValueInterface[] $imagesCollection
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        \Traversable $imagesCollection
    );

    /**
     * @param AttributeInterface                        $attribute
     * @param int                                       $valueId
     * @param \Traversable|ImageAttributeValueInterface[] $imagesCollection
     *
     * @return MediaGalleryAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        \Traversable $imagesCollection
    ) {
        $object = new static($attribute, $imagesCollection);

        $object->identifier = $valueId;

        return $object;
    }

    /**
     * @return bool
     */
    public function isScopable()
    {
        return false;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->imagesCollection->count();
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->imagesCollection->getIterator();
    }
}
