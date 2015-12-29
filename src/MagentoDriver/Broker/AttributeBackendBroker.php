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
     * @param AttributeInterface $attribute
     * @return BackendInterface|null
     */
    public function find(AttributeInterface $attribute)
    {
        foreach ($this->backends as $backendInfo) {
            if ($backendInfo['matcher']($attribute) === true) {
                return $backendInfo['backend'];
            }
        }

        return null;
    }
}