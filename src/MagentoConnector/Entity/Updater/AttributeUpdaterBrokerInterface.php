<?php

namespace Luni\Component\MagentoConnector\Entity\Updater;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

interface AttributeUpdaterBrokerInterface
{
    /**
     * @param AttributeInterface $attribute
     * @return MagentoProductUpdaterInterface|null
     */
    public function selectFor(AttributeInterface $attribute);
}