<?php

namespace Luni\Component\MagentoSerializer\Denormalization\AttributeValue;


use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DummyAttributeValueDenormalization
    implements DenormalizerInterface
{
    /**
     * @param mixed $data
     * @param string $class
     * @param null $format
     * @param array $context
     * @return AttributeValueInterface
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return null;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return false;
    }
}