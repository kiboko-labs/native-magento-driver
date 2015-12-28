<?php

namespace Luni\Component\MagentoDriver\Entity\Updater\Magento;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Entity\Updater\AttributeUpdaterBrokerInterface;
use Luni\Component\MagentoDriver\Entity\Updater\MagentoProductUpdaterInterface;

class StandardAttributeUpdaterBroker
    implements AttributeUpdaterBrokerInterface
{
    /**
     * @var Collection|MagentoProductUpdaterInterface[]
     */
    private $attributeUpdaters;

    /**
     * StandardAttributeUpdaterBroker constructor.
     */
    public function __construct()
    {
        $this->attributeUpdaters = new ArrayCollection();
    }

    /**
     * @param MagentoProductUpdaterInterface $updater
     * @param string $backend
     */
    public function addAttributeUpdater(MagentoProductUpdaterInterface $updater, $backend)
    {
        $this->attributeUpdaters->set($backend, $updater);
    }

    /**
     * @param AttributeInterface $attribute
     * @return MagentoProductUpdaterInterface|null
     */
    public function selectFor(AttributeInterface $attribute)
    {
        return $this->attributeUpdaters->get($attribute->getBackendType());
    }
}