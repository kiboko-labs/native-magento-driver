<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeLabel;
use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;

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
