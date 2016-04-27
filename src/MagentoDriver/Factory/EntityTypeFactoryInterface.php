<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityTypeInterface
     */
    public function buildNew(array $options);
}
