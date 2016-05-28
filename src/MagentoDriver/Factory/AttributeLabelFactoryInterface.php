<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeLabelInterface
     */
    public function buildNew(array $options);
}
