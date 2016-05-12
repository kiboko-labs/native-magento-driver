<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeLabelInterface
     */
    public function buildNew(array $options);
}
