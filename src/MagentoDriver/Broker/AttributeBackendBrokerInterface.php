<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Backend\Attribute\BackendInterface;

interface AttributeBackendBrokerInterface
{
    /**
     * @param BackendInterface $backend
     * @param Closure $matcher
     */
    public function addBackend(BackendInterface $backend, Closure $matcher);

    /**
     * @param AttributeInterface $attribute
     * @return BackendInterface|null
     */
    public function find(AttributeInterface $attribute);
}