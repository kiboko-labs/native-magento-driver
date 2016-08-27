<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface MediaGalleryAttributeValueInterface extends AttributeValueInterface, MappableInterface, \Countable, \IteratorAggregate
{
    public function addMedia(ImageAttributeValueInterface $attributeValue);
}
