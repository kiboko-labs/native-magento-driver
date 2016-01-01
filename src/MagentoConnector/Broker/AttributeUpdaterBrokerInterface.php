<?php

namespace Luni\Component\MagentoConnector\Broker;

use Luni\Component\MagentoConnector\Entity\Updater\MagentoProductUpdaterInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeUpdaterBrokerInterface
{
    /**
     * @param AttributeInterface $attribute
     * @return MagentoProductUpdaterInterface|null
     */
    public function selectFor(AttributeInterface $attribute);
}