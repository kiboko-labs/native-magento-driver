<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityTypeInterface
     */
    public function buildNew(array $options);
}
