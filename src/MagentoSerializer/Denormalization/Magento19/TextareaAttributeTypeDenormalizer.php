<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoSerializer\Denormalization\Magento19;

use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttribute;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttributeExtension;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TextareaAttributeTypeDenormalizer implements DenormalizerInterface
{
    /**
     * @param mixed  $data
     * @param string $class
     * @param null   $format
     * @param array  $context
     *
     * @return array
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return [
            new CatalogAttribute(
                new Attribute(
                    $this->entityTypeMapper->map($data->getEntityType()), // entity_type_id
                    $attribute->getCode(),                                     // attribute_code
                    null,                                                      // attribute_model
                    'text',                                                    // backend_type
                    null,                                                      // backend_model
                    null,                                                      // backend_table
                    null,                                                      // frontend_model
                    'textarea',                                                // frontend_input
                    $attribute->getLabel(),                                    // frontend_label
                    null,                                                      // frontend_class
                    null,                                                      // source_model
                    $attribute->isRequired(),                                  // is_required
                    true,                                                      // is_user_defined
                    $attribute->isUnique(),                                    // is_unique
                    null,                                                      // default_value
                    null                                                       // note
                ),
                new CatalogAttributeExtension(

                )
            ),
        ];
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
        return 'magento' === $format &&
            false !== ($interfaces = class_implements($type, true)) &&
            in_array(AttributeInterface::class, $interfaces);
    }
}
