<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\Attribute;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;

class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeInterface
     */
    public function buildNew(array $options)
    {
        return Attribute::buildNewWith(
            $this->readInteger($options, 'attribute_id', null),
            $this->readInteger($options, 'entity_type_id', null),
            $this->readString($options, 'attribute_code', null),
            $this->readString($options, 'attribute_model', null),
            $this->readString($options, 'backend_type', null),
            $this->readString($options, 'backend_model', null),
            $this->readString($options, 'backend_table', null),
            $this->readString($options, 'frontend_model', null),
            $this->readString($options, 'frontend_input', null),
            $this->readString($options, 'frontend_label', null),
            $this->readString($options, 'frontend_class', null),
            $this->readString($options, 'source_model', null),
            $this->readBoolean($options, 'is_required', false),
            $this->readBoolean($options, 'is_user_defined', false),
            $this->readBoolean($options, 'is_unique', false),
            $this->readString($options, 'default_value', null)
        );
    }

    private function readInteger($options, $key, $default = null)
    {
        return (int) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readString($options, $key, $default = null)
    {
        return (string) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readBoolean($options, $key, $default = null)
    {
        return (bool) (isset($options[$key]) ? $options[$key] : $default);
    }
}
