<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoSerializer\Denormalization\AttributeValue;

use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DummyAttributeValueDenormalization implements DenormalizerInterface
{
    /**
     * @param mixed  $data
     * @param string $class
     * @param null   $format
     * @param array  $context
     *
     * @return AttributeValueInterface
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return;
    }

    /**
     * @param mixed  $data
     * @param string $type
     * @param null   $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return false;
    }
}
