<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Backend\AttributeValue\BackendInterface;

interface AttributeBackendBrokerInterface
{
    /**
     * @param BackendInterface $backend
     * @param Closure $matcher
     */
    public function addBackend(BackendInterface $backend, Closure $matcher);

    /**
     * @return \Generator|BackendInterface[]
     */
    public function walkBackendList();

    /**
     * @param AttributeInterface $attribute
     * @return BackendInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}