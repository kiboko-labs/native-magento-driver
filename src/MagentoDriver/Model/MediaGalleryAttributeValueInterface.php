<?php

namespace Luni\Component\MagentoDriver\Model;

interface MediaGalleryAttributeValueInterface extends AttributeValueInterface, \Countable, \IteratorAggregate
{
    public function addMedia(ImageAttributeValueInterface $attributeValue);
}
