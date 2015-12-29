<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Backend\Attribute\BackendInterface;

class AttributeBackendBroker
    implements AttributeBackendBrokerInterface
{
    /**
     * @var Collection
     */
    private $backends;

    /**
     * AttributeBackendBroker constructor.
     */
    public function __construct()
    {
        $this->backends = new ArrayCollection();
    }

    /**
     * @param BackendInterface $backend
     * @param Closure $matcher
     */
    public function addBackend(BackendInterface $backend, Closure $matcher)
    {
        $this->backends->add([
            'matcher' => $matcher,
            'backend' => $backend
        ]);
    }

    /**
     * @return \Generator|BackendInterface[]
     */
    public function walkBackendList()
    {
        foreach ($this->backends as $backendInfo) {
            yield $backendInfo['matcher'] => $backendInfo['backend'];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @return BackendInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        foreach ($this->walkBackendList() as $matcher => $backend) {
            if ($matcher($attribute) === true) {
                return $backend;
            }
        }

        return null;
    }
}