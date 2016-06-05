<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Doctrine\Common\Collections\Collection;

trait MediaGalleryAttributeValueTrait
{
    use AttributeValueTrait;

    /**
     * @var Collection|ImageAttributeValueInterface[]
     */
    private $imagesCollection;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface                        $attribute
     * @param Collection|ImageAttributeValueInterface[] $imagesCollection
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        Collection $imagesCollection
    );

    /**
     * @param AttributeInterface                        $attribute
     * @param int                                       $valueId
     * @param Collection|ImageAttributeValueInterface[] $imagesCollection
     *
     * @return MediaGalleryAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        Collection $imagesCollection
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
