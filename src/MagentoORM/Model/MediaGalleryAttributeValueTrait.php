<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

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
     * @param AttributeInterface                          $attribute
     * @param \Traversable|ImageAttributeValueInterface[] $imagesCollection
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        \Traversable $imagesCollection
    );

    /**
     * @param int                                         $valueId
     * @param AttributeInterface                          $attribute
     * @param \Traversable|ImageAttributeValueInterface[] $imagesCollection
     *
     * @return MediaGalleryAttributeValueInterface
     */
    public static function buildNewWith(
        $valueId,
        AttributeInterface $attribute,
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
