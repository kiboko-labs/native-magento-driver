<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface MediaGalleryAttributeValueInterface
    extends AttributeValueInterface, \Countable, \IteratorAggregate
{
    public function addMedia(ImageAttributeValueInterface $attributeValue);
}