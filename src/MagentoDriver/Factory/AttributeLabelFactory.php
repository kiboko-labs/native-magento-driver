<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeLabel;
use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AttributeLabelFactory implements AttributeLabelFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeLabelInterface
     */
    public function buildNew(array $options)
    {
        return AttributeLabel::buildNewWith(
            $options['attribute_label_id'],
            $options['attribute_id'],
            $options['store_id'],
            isset($options['value']) ? $options['value'] : null
        );
    }
}
