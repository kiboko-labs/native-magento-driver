<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Backend\Attribute\BackendInterface;

interface AttributeBackendBrokerInterface
{
    /**
     * @param BackendInterface $backend
     * @param Closure $matcher
     */
    public function addBackend(BackendInterface $backend, Closure $matcher);

    /**
     * @param int $attributeId
     * @param string $attributeCode
     * @param array $attributeOptions
     * @return BackendInterface|null
     */
    public function find($attributeId, $attributeCode, array $attributeOptions);
}