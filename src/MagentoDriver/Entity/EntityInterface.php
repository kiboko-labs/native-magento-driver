<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\Immutable\ImmutableVarcharAttributeValue;

interface EntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return AttributeInterface[]|Collection
     */
    public function getAttributes();

    /**
     * @return AttributeValueInterface[]|Collection
     */
    public function getValues();
}