<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface MediaGalleryAttributeValueInterface
    extends AttributeValueInterface, \Countable, \IteratorAggregate
{
    public function addMedia(ImageAttributeValueInterface $attributeValue);
}